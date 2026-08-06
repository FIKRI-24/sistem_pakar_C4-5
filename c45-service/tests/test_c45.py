import pytest
import math
from app.c45.c45_engine import (
    calculate_entropy,
    calculate_split_info,
    evaluate_categorical_split,
    evaluate_numeric_split,
    build_tree,
    classify,
    extract_rules,
    get_classification_path
)

def test_calculate_entropy():
    # Homogeneous set
    assert calculate_entropy(["yes", "yes", "yes"]) == 0.0
    # Empty set
    assert calculate_entropy([]) == 0.0
    # Balanced set (2 classes, 50% each)
    assert calculate_entropy(["yes", "no"]) == 1.0
    # 4 items: 3 yes, 1 no
    # - (0.75 * log2(0.75) + 0.25 * log2(0.25)) = - (0.75 * -0.415 + 0.25 * -2.0) = 0.811
    assert pytest.approx(calculate_entropy(["yes", "yes", "yes", "no"]), 0.01) == 0.811

def test_calculate_split_info():
    # Empty partitions
    assert calculate_split_info([]) == 0.0
    # Equal partition sizes
    assert calculate_split_info([[1, 2], [3, 4]]) == 1.0
    # Proportions: 3/4 and 1/4
    assert pytest.approx(calculate_split_info([[1, 2, 3], [4]]), 0.01) == 0.811

def test_evaluate_categorical_split():
    # Perfectly predictive split
    X_attr = ["A", "A", "B", "B"]
    y = ["yes", "yes", "no", "no"]
    gain, split_info = evaluate_categorical_split(X_attr, y)
    assert gain == 1.0  # complete entropy reduction (1.0 - 0.0)
    assert split_info == 1.0

def test_evaluate_numeric_split():
    X_attr = [10.0, 20.0, 30.0, 40.0]
    y = ["no", "no", "yes", "yes"]
    gain, split_info, threshold = evaluate_numeric_split(X_attr, y)
    assert gain == 1.0
    assert threshold == 25.0
    assert split_info == 1.0

def test_build_tree_and_classify_play_tennis():
    # Mini dataset
    # Atributes: minat (Outlook), bakat (Temp), nilai_akademik (Humidity), kepribadian (Wind)
    # Output: play (yes / no)
    # Let's map it:
    X = [
        {"minat": "Sunny", "bakat": "Hot", "nilai_akademik": 85.0, "kepribadian": "Weak"},
        {"minat": "Sunny", "bakat": "Hot", "nilai_akademik": 90.0, "kepribadian": "Strong"},
        {"minat": "Overcast", "bakat": "Hot", "nilai_akademik": 78.0, "kepribadian": "Weak"},
        {"minat": "Rain", "bakat": "Mild", "nilai_akademik": 96.0, "kepribadian": "Weak"},
        {"minat": "Rain", "bakat": "Cool", "nilai_akademik": 80.0, "kepribadian": "Weak"},
        {"minat": "Rain", "bakat": "Cool", "nilai_akademik": 70.0, "kepribadian": "Strong"},
        {"minat": "Overcast", "bakat": "Cool", "nilai_akademik": 65.0, "kepribadian": "Strong"},
        {"minat": "Sunny", "bakat": "Mild", "nilai_akademik": 95.0, "kepribadian": "Weak"},
        {"minat": "Sunny", "bakat": "Cool", "nilai_akademik": 70.0, "kepribadian": "Weak"},
        {"minat": "Rain", "bakat": "Mild", "nilai_akademik": 80.0, "kepribadian": "Weak"},
        {"minat": "Sunny", "bakat": "Mild", "nilai_akademik": 70.0, "kepribadian": "Strong"},
        {"minat": "Overcast", "bakat": "Mild", "nilai_akademik": 90.0, "kepribadian": "Strong"},
        {"minat": "Overcast", "bakat": "Hot", "nilai_akademik": 75.0, "kepribadian": "Weak"},
        {"minat": "Rain", "bakat": "Mild", "nilai_akademik": 80.0, "kepribadian": "Strong"},
    ]
    y = ["no", "no", "yes", "yes", "yes", "no", "yes", "no", "yes", "yes", "yes", "yes", "yes", "no"]
    features = ["minat", "bakat", "nilai_akademik", "kepribadian"]
    
    # We build tree with min_samples_leaf=1 to allow complete split
    tree = build_tree(X, y, features, min_samples_leaf=1)
    
    assert tree is not None
    assert tree["type"] == "split"
    
    # Let's test classification
    # Sunny + high humidity (> 75) => play should be "no"
    sample_sunny_high_hum = {"minat": "Sunny", "bakat": "Hot", "nilai_akademik": 85.0, "kepribadian": "Weak"}
    label, conf = classify(tree, sample_sunny_high_hum)
    assert label == "no"
    
    # Overcast => always "yes"
    sample_overcast = {"minat": "Overcast", "bakat": "Hot", "nilai_akademik": 75.0, "kepribadian": "Weak"}
    label, conf = classify(tree, sample_overcast)
    assert label == "yes"
    
    # Rain + strong wind => "no"
    sample_rain_strong = {"minat": "Rain", "bakat": "Mild", "nilai_akademik": 80.0, "kepribadian": "Strong"}
    label, conf = classify(tree, sample_rain_strong)
    assert label == "no"

    # Extract rules
    rules = extract_rules(tree)
    assert len(rules) > 0
    for rule in rules:
        assert "class" in rule
        assert "conditions" in rule

def test_get_classification_path():
    # Construct a small manual tree
    tree = {
        "type": "split",
        "feature": "minat",
        "is_numeric": False,
        "default_class": "unkn",
        "branches": {
            "Investigative": {
                "type": "split",
                "feature": "nilai_akademik",
                "is_numeric": True,
                "threshold": 80.0,
                "default_class": "A",
                "left": {"type": "leaf", "class": "A", "count": 2, "distribution": {"A": 2}},
                "right": {"type": "leaf", "class": "B", "count": 3, "distribution": {"B": 3}}
            }
        }
    }
    
    path1 = get_classification_path(tree, {"minat": "Investigative", "nilai_akademik": 75.0})
    assert path1 == ["Minat = 'Investigative'", "Nilai Akademik <= 80.00"]
    
    path2 = get_classification_path(tree, {"minat": "Investigative", "nilai_akademik": 85.0})
    assert path2 == ["Minat = 'Investigative'", "Nilai Akademik > 80.00"]

