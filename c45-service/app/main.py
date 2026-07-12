"""FastAPI application factory and ASGI entry point."""

from fastapi import FastAPI, status
from pydantic import BaseModel

from app.core.config import Settings, get_settings


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

    return application


app = create_app()
