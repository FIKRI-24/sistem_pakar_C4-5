import os
import urllib.parse
from typing import Generator
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker, declarative_base
from app.core.config import get_settings

settings = get_settings()

# Check for explicit DATABASE_URL or MYSQL_URL
raw_url = os.getenv("DATABASE_URL") or os.getenv("MYSQL_URL") or os.getenv("MYSQL_PRIVATE_URL")

if raw_url:
    if raw_url.startswith("mysql://"):
        DATABASE_URL = raw_url.replace("mysql://", "mysql+pymysql://", 1)
    else:
        DATABASE_URL = raw_url
else:
    # Build MySQL connection string with fallback environment variables
    db_user = os.getenv("C45_DB_USERNAME") or os.getenv("DB_USERNAME") or os.getenv("DB_USER") or os.getenv("MYSQLUSER") or settings.db_username
    db_pass = os.getenv("C45_DB_PASSWORD") or os.getenv("DB_PASSWORD") or os.getenv("MYSQLPASSWORD") or settings.db_password
    db_host = os.getenv("C45_DB_HOST") or os.getenv("DB_HOST") or os.getenv("MYSQLHOST") or settings.db_host
    db_port = os.getenv("C45_DB_PORT") or os.getenv("DB_PORT") or os.getenv("MYSQLPORT") or str(settings.db_port)
    db_name = os.getenv("C45_DB_DATABASE") or os.getenv("DB_DATABASE") or os.getenv("DB_NAME") or os.getenv("MYSQLDATABASE") or settings.db_database

    password_encoded = urllib.parse.quote_plus(db_pass) if db_pass else ""
    if password_encoded:
        DATABASE_URL = (
            f"mysql+pymysql://{db_user}:{password_encoded}"
            f"@{db_host}:{db_port}/{db_name}"
            f"?charset=utf8mb4"
        )
    else:
        DATABASE_URL = (
            f"mysql+pymysql://{db_user}"
            f"@{db_host}:{db_port}/{db_name}"
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

