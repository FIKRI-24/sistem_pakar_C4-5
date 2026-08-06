"""Environment-backed application settings."""

from functools import lru_cache
from typing import Literal

from pydantic import Field
from pydantic_settings import BaseSettings, SettingsConfigDict


class Settings(BaseSettings):
    """Runtime settings loaded from C45_* environment variables."""

    model_config = SettingsConfigDict(
        env_file=".env",
        env_file_encoding="utf-8",
        env_prefix="C45_",
        case_sensitive=False,
        extra="ignore",
    )

    app_name: str = "C4.5 Career Recommendation Service"
    app_version: str = "0.1.0"
    environment: Literal["development", "testing", "staging", "production"] = (
        "development"
    )
    host: str = "127.0.0.1"
    port: int = Field(default=8001, ge=1, le=65535)
    log_level: Literal["critical", "error", "warning", "info", "debug", "trace"] = (
        "info"
    )

    # Database configuration
    db_host: str = "127.0.0.1"
    db_port: int = 3306
    db_database: str = "sistem_pakar"
    db_username: str = "root"
    db_password: str = ""


@lru_cache
def get_settings() -> Settings:
    """Return one settings instance for the lifetime of the process."""

    return Settings()
