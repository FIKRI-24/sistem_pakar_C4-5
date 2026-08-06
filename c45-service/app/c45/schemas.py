from pydantic import BaseModel, Field

class ClassifyRequest(BaseModel):
    minat: str = Field(..., description="Minat RIASEC category")
    bakat: str = Field(..., description="Bakat DAT category")
    nilai_akademik: float = Field(..., description="Average academic score (0.0 to 100.0)", ge=0.0, le=100.0)
    kepribadian: str = Field(..., description="Kepribadian DISC category")

class ClassifyResponse(BaseModel):
    karir_id: int = Field(..., description="Recommended career ID")
    nama_karir: str = Field(..., description="Recommended career name")
    persen_kecocokan: float = Field(..., description="Classification confidence/matching percentage")
    alasan: str = Field(..., description="Path condition rules serving as reasoning")

class TrainRequest(BaseModel):
    dibuat_oleh: int = Field(..., description="User ID of the administrator/counselor trigger")

class TrainResponse(BaseModel):
    status: str = Field(..., description="Status message")
    versi: int = Field(..., description="Created decision tree version")
    akurasi: float = Field(..., description="Training accuracy (0.0 to 1.0)")
