import urllib.parse
from typing import Generator
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker, declarative_base
from app.core.config import get_settings

settings = get_settings()

# Build MySQL connection string
password_encoded = urllib.parse.quote_plus(settings.db_password) if settings.db_password else ""
if password_encoded:
    DATABASE_URL = (
        f"mysql+pymysql://{settings.db_username}:{password_encoded}"
        f"@{settings.db_host}:{settings.db_port}/{settings.db_database}"
        f"?charset=utf8mb4"
    )
else:
    DATABASE_URL = (
        f"mysql+pymysql://{settings.db_username}"
        f"@{settings.db_host}:{settings.db_port}/{settings.db_database}"
        f"?charset=utf8mb4"
    )

engine = create_engine(
    DATABASE_URL,
    pool_pre_ping=True,
    pool_recycle=3600,
)

SessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)

Base = declarative_base()

def get_db() -> Generator:
    """FastAPI database session dependency."""
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()
