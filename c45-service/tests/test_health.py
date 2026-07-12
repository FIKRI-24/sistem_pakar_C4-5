"""Contract tests for the health endpoint."""

from fastapi.testclient import TestClient

from app.core.config import Settings
from app.main import create_app


def test_health_returns_service_metadata() -> None:
    settings = Settings(environment="testing", _env_file=None)

    with TestClient(create_app(settings)) as client:
        response = client.get("/health")

    assert response.status_code == 200
    assert response.json() == {
        "status": "ok",
        "service": "c45-service",
        "version": "0.1.0",
        "environment": "testing",
    }
    assert response.headers["content-type"].startswith("application/json")
