"""FastAPI application factory and ASGI entry point."""

from fastapi import FastAPI, Depends, HTTPException, status
from sqlalchemy.orm import Session

from app.core.config import Settings, get_settings
from app.core.database import get_db, Base, engine
from app.c45.schemas import ClassifyRequest, ClassifyResponse, TrainRequest, TrainResponse
from app.c45.c45_engine import build_tree, classify, get_classification_path, extract_rules
from app.c45.crud import (
    fetch_training_data,
    save_decision_tree,
    fetch_active_decision_tree,
    get_career_name_map
)

# Ensure tables are created if they don't exist (though Laravel handles migrations)
# Base.metadata.create_all(bind=engine)

from pydantic import BaseModel

class HealthResponse(BaseModel):
    """Public response contract for service readiness checks."""
    status: str
    service: str
    version: str
    environment: str


def create_app(settings: Settings | None = None) -> FastAPI:
    """Create the FastAPI application using the supplied runtime settings."""

    runtime_settings = settings or get_settings()
    application = FastAPI(
        title=runtime_settings.app_name,
        version=runtime_settings.app_version,
        description="HTTP service for the Karir Siswa recommendation engine.",
    )

    @application.get(
        "/health",
        response_model=HealthResponse,
        status_code=status.HTTP_200_OK,
        tags=["System"],
        summary="Check service health",
    )
    def health() -> HealthResponse:
        return HealthResponse(
            status="ok",
            service="c45-service",
            version=runtime_settings.app_version,
            environment=runtime_settings.environment,
        )

    @application.post(
        "/train",
        response_model=TrainResponse,
        status_code=status.HTTP_200_OK,
        tags=["C4.5 Engine"],
        summary="Train a new decision tree model using database training data",
    )
    def train_model(request: TrainRequest, db: Session = Depends(get_db)) -> TrainResponse:
        X, y, careers_map = fetch_training_data(db)
        if not y:
            raise HTTPException(
                status_code=status.HTTP_400_BAD_REQUEST,
                detail="Tidak ada data training yang cukup di database untuk melatih model."
            )
        
        features = ["minat", "bakat", "nilai_akademik", "kepribadian"]
        # Build tree using custom C4.5
        tree_dict = build_tree(X, y, features, min_samples_leaf=2)
        
        # Calculate training accuracy (resubstitution accuracy)
        correct = 0
        for sample, target in zip(X, y):
            pred, _ = classify(tree_dict, sample)
            if pred == target:
                correct += 1
        accuracy = correct / len(y) if y else 0.0
        
        # Save decision tree to database
        versi = save_decision_tree(db, tree_dict, accuracy, request.dibuat_oleh)
        
        return TrainResponse(status="success", versi=versi, akurasi=accuracy)

    @application.post(
        "/classify",
        response_model=ClassifyResponse,
        status_code=status.HTTP_200_OK,
        tags=["C4.5 Engine"],
        summary="Classify a student profile and return career recommendation",
    )
    def classify_instance(request: ClassifyRequest, db: Session = Depends(get_db)) -> ClassifyResponse:
        active_tree = fetch_active_decision_tree(db)
        if not active_tree:
            raise HTTPException(
                status_code=status.HTTP_404_NOT_FOUND,
                detail="Pohon keputusan aktif tidak ditemukan. Silakan lakukan latih ulang pohon (train) terlebih dahulu."
            )
        
        tree_dict, accuracy, versi = active_tree
        sample = request.model_dump()
        
        predicted_career_id, confidence = classify(tree_dict, sample)
        
        careers_map = get_career_name_map(db)
        nama_karir = careers_map.get(predicted_career_id)
        if not nama_karir:
            raise HTTPException(
                status_code=status.HTTP_404_NOT_FOUND,
                detail=f"Alternatif Karir dengan ID {predicted_career_id} tidak ditemukan di database."
            )
            
        # Get path conditions
        path_conditions = get_classification_path(tree_dict, sample)
        alasan = " dan ".join(path_conditions) if path_conditions else "Rekomendasi default (pohon keputusan akar tunggal)."
        
        return ClassifyResponse(
            karir_id=predicted_career_id,
            nama_karir=nama_karir,
            persen_kecocokan=confidence * 100.0,
            alasan=alasan
        )

    @application.get(
        "/tree/latest",
        status_code=status.HTTP_200_OK,
        tags=["C4.5 Engine"],
        summary="Retrieve the active decision tree JSON structure",
    )
    def get_latest_tree(db: Session = Depends(get_db)) -> dict:
        active_tree = fetch_active_decision_tree(db)
        if not active_tree:
            raise HTTPException(
                status_code=status.HTTP_404_NOT_FOUND,
                detail="Pohon keputusan aktif tidak ditemukan."
            )
        tree_dict, accuracy, versi = active_tree
        return {
            "versi": versi,
            "akurasi": accuracy,
            "tree": tree_dict
        }

    @application.get(
        "/tree/rules",
        status_code=status.HTTP_200_OK,
        tags=["C4.5 Engine"],
        summary="Retrieve all extracted rules of the active decision tree",
    )
    def get_tree_rules(db: Session = Depends(get_db)) -> dict:
        active_tree = fetch_active_decision_tree(db)
        if not active_tree:
            raise HTTPException(
                status_code=status.HTTP_404_NOT_FOUND,
                detail="Pohon keputusan aktif tidak ditemukan."
            )
        tree_dict, accuracy, versi = active_tree
        
        rules = extract_rules(tree_dict)
        
        # Map career IDs to names for readability of rules
        careers_map = get_career_name_map(db)
        
        formatted_rules = []
        for r in rules:
            class_id = r["class"]
            career_name = careers_map.get(class_id, f"ID {class_id}")
            conds = " AND ".join(r["conditions"]) if r["conditions"] else "Always"
            dist = r.get("distribution", {})
            # Map distribution classes to career names
            dist_mapped = {careers_map.get(int(cid) if isinstance(cid, (str, int)) and str(cid).isdigit() else cid, f"ID {cid}"): count for cid, count in dist.items()}
            dist_str = ", ".join(f"{c}: {cnt}" for c, cnt in dist_mapped.items())
            
            formatted_rules.append({
                "rule": f"IF {conds} THEN Rekomendasikan Karir = '{career_name}' (Sampel: {r['count']}, Distribusi: [{dist_str}])",
                "career_id": class_id,
                "career_name": career_name,
                "conditions": r["conditions"],
                "count": r["count"]
            })
            
        return {
            "versi": versi,
            "akurasi": accuracy,
            "rules": formatted_rules
        }

    return application


app = create_app()
