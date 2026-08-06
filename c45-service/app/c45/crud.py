import json
from typing import Any, Dict, List, Optional, Tuple
from sqlalchemy.orm import Session
from sqlalchemy.sql import text
from app.c45.c45_engine import classify

def fetch_training_data(db: Session) -> Tuple[List[Dict[str, Any]], List[Any], Dict[int, str]]:
    """Fetch and format training data from database.
    
    Returns (X, y, careers_map) where:
    - X: list of dicts with keys: 'minat', 'bakat', 'nilai_akademik', 'kepribadian'
    - y: list of target class labels (karir_id)
    - careers_map: dict mapping karir_id to nama_karir
    """
    # Fetch careers map
    careers_query = text("SELECT id, nama_karir FROM karirs")
    careers_rows = db.execute(careers_query).fetchall()
    careers_map = {row[0]: row[1] for row in careers_rows}

    # Fetch training records grouped by training ID
    # Join data_trainings with attributes and criteria
    query = text("""
        SELECT 
            dt.id AS training_id, 
            dt.label_karir_id, 
            k.nama_kriteria, 
            dta.nilai_kategorik, 
            dta.nilai_numerik
        FROM data_trainings dt
        JOIN data_training_atributs dta ON dt.id = dta.data_training_id
        JOIN kriterias k ON dta.kriteria_id = k.id
    """)
    rows = db.execute(query).fetchall()

    # Group by training_id
    grouped_data: Dict[int, Dict[str, Any]] = {}
    targets: Dict[int, int] = {}

    # Criterion name to API contract key
    attr_keys = {
        "Minat": "minat",
        "Bakat": "bakat",
        "Nilai Akademik": "nilai_akademik",
        "Kepribadian": "kepribadian"
    }

    for row in rows:
        t_id, label_id, k_name, val_kat, val_num = row
        if t_id not in grouped_data:
            grouped_data[t_id] = {}
            targets[t_id] = label_id
        
        key = attr_keys.get(k_name)
        if key:
            if k_name == "Nilai Akademik":
                grouped_data[t_id][key] = float(val_num) if val_num is not None else 0.0
            else:
                grouped_data[t_id][key] = val_kat

    # Ensure all rows have all 4 features (ignore incomplete ones)
    X: List[Dict[str, Any]] = []
    y: List[Any] = []
    
    expected_keys = {"minat", "bakat", "nilai_akademik", "kepribadian"}
    for t_id, features in grouped_data.items():
        if set(features.keys()) == expected_keys:
            X.append(features)
            y.append(targets[t_id])

    return X, y, careers_map

def save_decision_tree(db: Session, tree_dict: Dict[str, Any], akurasi: float, dibuat_oleh: int) -> int:
    """Save the decision tree to database and make it the only active version."""
    # Find next version number
    version_query = text("SELECT MAX(versi) FROM decision_trees")
    max_ver = db.execute(version_query).scalar()
    next_ver = 1 if max_ver is None else int(max_ver) + 1

    # Deactivate all existing decision trees
    deactivate_query = text("UPDATE decision_trees SET status_aktif = 0")
    db.execute(deactivate_query)

    # Insert new decision tree
    tree_json = json.dumps(tree_dict)
    insert_query = text("""
        INSERT INTO decision_trees (versi, struktur_json, akurasi, dibuat_oleh, status_aktif, created_at)
        VALUES (:versi, :struktur_json, :akurasi, :dibuat_oleh, 1, NOW())
    """)
    db.execute(insert_query, {
        "versi": next_ver,
        "struktur_json": tree_json,
        "akurasi": akurasi,
        "dibuat_oleh": dibuat_oleh
    })
    
    db.commit()
    return next_ver

def fetch_active_decision_tree(db: Session) -> Optional[Tuple[Dict[str, Any], float, int]]:
    """Fetch the active decision tree from the database.
    
    Returns (tree_dict, akurasi, versi) or None.
    """
    query = text("""
        SELECT struktur_json, akurasi, versi 
        FROM decision_trees 
        WHERE status_aktif = 1 
        LIMIT 1
    """)
    row = db.execute(query).fetchone()
    if row:
        tree_json, akurasi, versi = row
        # Handle string or loaded dict/JSON depending on driver
        if isinstance(tree_json, str):
            tree_dict = json.loads(tree_json)
        else:
            tree_dict = tree_json
        return tree_dict, float(akurasi) if akurasi is not None else 0.0, int(versi)
    return None

def get_career_name_map(db: Session) -> Dict[int, str]:
    """Get mapping of career ID to name."""
    query = text("SELECT id, nama_karir FROM karirs")
    rows = db.execute(query).fetchall()
    return {row[0]: row[1] for row in rows}
