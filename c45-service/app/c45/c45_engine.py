import math
from collections import Counter
from typing import Any, Dict, List, Tuple, Union

def calculate_entropy(y: List[Any]) -> float:
    """Calculate the Shannon entropy of a list of labels."""
    if not y:
        return 0.0
    total = len(y)
    counts = Counter(y)
    entropy = 0.0
    for count in counts.values():
        p = count / total
        if p > 0:
            entropy -= p * math.log2(p)
    return entropy

def calculate_split_info(partitions: List[List[Any]]) -> float:
    """Calculate the Split Information of a partitioning."""
    total = sum(len(part) for part in partitions)
    if total == 0:
        return 0.0
    split_info = 0.0
    for part in partitions:
        p = len(part) / total
        if p > 0:
            split_info -= p * math.log2(p)
    return split_info

def get_majority_class(y: List[Any]) -> Any:
    """Get the majority class from a list of labels."""
    if not y:
        return None
    counts = Counter(y)
    return counts.most_common(1)[0][0]

def get_class_distribution(y: List[Any]) -> Dict[Any, int]:
    """Get the frequency of each class in y."""
    return dict(Counter(y))

def evaluate_categorical_split(X_attr: List[Any], y: List[Any]) -> Tuple[float, float]:
    """Evaluate a categorical attribute split.
    
    Returns (gain, split_info).
    """
    total_entropy = calculate_entropy(y)
    total_samples = len(y)
    if total_samples == 0:
        return 0.0, 0.0

    # Group target values by attribute values
    partitions_dict = {}
    for val, label in zip(X_attr, y):
        if val not in partitions_dict:
            partitions_dict[val] = []
        partitions_dict[val].append(label)

    partitions = list(partitions_dict.values())
    
    # Conditional entropy
    cond_entropy = 0.0
    for part in partitions:
        cond_entropy += (len(part) / total_samples) * calculate_entropy(part)
        
    gain = total_entropy - cond_entropy
    split_info = calculate_split_info(partitions)
    
    return gain, split_info

def evaluate_numeric_split(X_attr: List[float], y: List[Any]) -> Tuple[float, float, float]:
    """Evaluate a numeric attribute split across all candidate thresholds.
    
    Returns (best_gain, best_split_info, best_threshold).
    """
    total_samples = len(y)
    if total_samples == 0:
        return 0.0, 0.0, 0.0

    # Sort values and pair them with labels
    data = sorted(zip(X_attr, y), key=lambda x: x[0])
    sorted_attr = [d[0] for d in data]
    sorted_y = [d[1] for d in data]
    
    # Unique values to find candidate split points
    unique_vals = sorted(list(set(X_attr)))
    if len(unique_vals) <= 1:
        # Cannot split if there's only 1 unique value
        return 0.0, 0.0, unique_vals[0] if unique_vals else 0.0

    best_gain = -1.0
    best_split_info = 0.0
    best_threshold = 0.0
    total_entropy = calculate_entropy(y)

    # Candidate thresholds are midpoints between adjacent distinct sorted values
    for i in range(len(unique_vals) - 1):
        threshold = (unique_vals[i] + unique_vals[i + 1]) / 2.0
        
        # Partition data
        left_y = [sorted_y[j] for j in range(total_samples) if sorted_attr[j] <= threshold]
        right_y = [sorted_y[j] for j in range(total_samples) if sorted_attr[j] > threshold]
        
        if not left_y or not right_y:
            continue
            
        # Conditional entropy
        cond_entropy = ((len(left_y) / total_samples) * calculate_entropy(left_y) +
                        (len(right_y) / total_samples) * calculate_entropy(right_y))
                        
        gain = total_entropy - cond_entropy
        split_info = calculate_split_info([left_y, right_y])
        
        if gain > best_gain:
            best_gain = gain
            best_split_info = split_info
            best_threshold = threshold
            
    return best_gain, best_split_info, best_threshold

def build_tree(X: List[Dict[str, Any]], y: List[Any], features: List[str], min_samples_leaf: int = 2) -> Dict[str, Any]:
    """Recursively build a C4.5 Decision Tree."""
    # Base Case 1: Empty dataset
    if not y:
        return {"type": "leaf", "class": None, "count": 0, "distribution": {}}
        
    majority = get_majority_class(y)
    distribution = get_class_distribution(y)
    
    # Base Case 2: All samples belong to the same class
    if len(distribution) == 1:
        return {"type": "leaf", "class": y[0], "count": len(y), "distribution": distribution}
        
    # Base Case 3: Empty feature list or fewer than min_samples_leaf
    if not features or len(y) < min_samples_leaf:
        return {"type": "leaf", "class": majority, "count": len(y), "distribution": distribution}
        
    # Base Case 4: All samples have identical feature values
    all_identical = True
    first_sample = X[0]
    for sample in X[1:]:
        if any(sample[f] != first_sample[f] for f in features):
            all_identical = False
            break
    if all_identical:
        return {"type": "leaf", "class": majority, "count": len(y), "distribution": distribution}

    best_feature = None
    best_gain_ratio = -1.0
    best_threshold = None
    best_split_info = 0.0
    best_gain = 0.0

    # Calculate Gain Ratio for each feature
    # Feature types are: 'nilai_akademik' -> numeric, others -> categorical
    for feature in features:
        is_numeric = (feature == "nilai_akademik")
        X_attr = [sample[feature] for sample in X]
        
        if is_numeric:
            gain, split_info, threshold = evaluate_numeric_split(X_attr, y)
            gain_ratio = gain / split_info if split_info > 0 else 0.0
            if gain_ratio > best_gain_ratio:
                best_gain_ratio = gain_ratio
                best_feature = feature
                best_threshold = threshold
                best_split_info = split_info
                best_gain = gain
        else:
            gain, split_info = evaluate_categorical_split(X_attr, y)
            gain_ratio = gain / split_info if split_info > 0 else 0.0
            if gain_ratio > best_gain_ratio:
                best_gain_ratio = gain_ratio
                best_feature = feature
                best_threshold = None
                best_split_info = split_info
                best_gain = gain

    # If no improvement can be made (Gain Ratio is zero/negative)
    if best_gain_ratio <= 0.0:
        return {"type": "leaf", "class": majority, "count": len(y), "distribution": distribution}

    # Split the dataset
    is_numeric = (best_feature == "nilai_akademik")
    
    if is_numeric:
        left_indices = [i for i, sample in enumerate(X) if sample[best_feature] <= best_threshold]
        right_indices = [i for i, sample in enumerate(X) if sample[best_feature] > best_threshold]
        
        # If one of the branches is empty, return leaf
        if not left_indices or not right_indices:
            return {"type": "leaf", "class": majority, "count": len(y), "distribution": distribution}
            
        left_X = [X[i] for i in left_indices]
        left_y = [y[i] for i in left_indices]
        right_X = [X[i] for i in right_indices]
        right_y = [y[i] for i in right_indices]
        
        # Numeric attributes can be split again in subtrees, so do not remove the feature from the list
        left_child = build_tree(left_X, left_y, features, min_samples_leaf)
        right_child = build_tree(right_X, right_y, features, min_samples_leaf)
        
        return {
            "type": "split",
            "feature": best_feature,
            "is_numeric": True,
            "threshold": best_threshold,
            "default_class": majority,
            "left": left_child,
            "right": right_child,
            "count": len(y)
        }
    else:
        # Categorical attribute split
        # Group samples by the best feature's values
        value_groups = {}
        for i, sample in enumerate(X):
            val = sample[best_feature]
            if val not in value_groups:
                value_groups[val] = []
            value_groups[val].append(i)
            
        branches = {}
        # Remove the categorical feature from list for subtrees
        remaining_features = [f for f in features if f != best_feature]
        
        for val, indices in value_groups.items():
            child_X = [X[i] for i in indices]
            child_y = [y[i] for i in indices]
            branches[str(val)] = build_tree(child_X, child_y, remaining_features, min_samples_leaf)
            
        return {
            "type": "split",
            "feature": best_feature,
            "is_numeric": False,
            "default_class": majority,
            "branches": branches,
            "count": len(y)
        }

def classify(tree: Dict[str, Any], sample: Dict[str, Any]) -> Tuple[Any, float]:
    """Classify a single sample using the decision tree.
    
    Returns (class_label, confidence_score).
    """
    if tree["type"] == "leaf":
        total = tree.get("count", 1)
        if total == 0:
            return tree["class"], 1.0
        # Confidence score: proportion of majority class in the leaf node
        dist = tree.get("distribution", {})
        maj_class = tree["class"]
        maj_count = dist.get(maj_class, total)
        confidence = maj_count / total if total > 0 else 1.0
        return maj_class, confidence

    feature = tree["feature"]
    is_numeric = tree["is_numeric"]
    
    if is_numeric:
        val = sample.get(feature)
        if val is None:
            # Fallback to default class of the node if missing
            return tree["default_class"], 1.0
        if val <= tree["threshold"]:
            return classify(tree["left"], sample)
        else:
            return classify(tree["right"], sample)
    else:
        val = str(sample.get(feature))
        if val is None or val not in tree["branches"]:
            # Fallback to default class of the node if value not in training branches
            return tree["default_class"], 1.0
        return classify(tree["branches"][val], sample)

def extract_rules(tree: Dict[str, Any], current_path: List[str] = None) -> List[Dict[str, Any]]:
    """Recursively extract C4.5 decision paths into human-readable rules."""
    if current_path is None:
        current_path = []
        
    if tree["type"] == "leaf":
        conditions_str = " AND ".join(current_path) if current_path else "Always"
        return [{
            "conditions": list(current_path),
            "conditions_str": conditions_str,
            "class": tree["class"],
            "count": tree.get("count", 0),
            "distribution": tree.get("distribution", {})
        }]
        
    feature = tree["feature"]
    rules = []
    
    if tree["is_numeric"]:
        threshold = tree["threshold"]
        # Left branch (<= threshold)
        left_path = current_path + [f"{feature} <= {threshold:.2f}"]
        rules.extend(extract_rules(tree["left"], left_path))
        # Right branch (> threshold)
        right_path = current_path + [f"{feature} > {threshold:.2f}"]
        rules.extend(extract_rules(tree["right"], right_path))
    else:
        # Categorical branches
        for val, branch in tree["branches"].items():
            branch_path = current_path + [f"{feature} = '{val}'"]
            rules.extend(extract_rules(branch, branch_path))
            
    return rules

def rule_to_string(rule: Dict[str, Any]) -> str:
    """Format a rule dict into a readable string."""
    conds = " AND ".join(rule["conditions"]) if rule["conditions"] else "Always"
    dist = rule.get("distribution", {})
    dist_str = ", ".join(f"{c}:{cnt}" for c, cnt in dist.items())
    return f"IF {conds} THEN Recommend Career = {rule['class']} (samples: {rule['count']}, dist: [{dist_str}])"

def get_classification_path(tree: Dict[str, Any], sample: Dict[str, Any]) -> List[str]:
    """Trace the path taken by a sample during classification."""
    if tree["type"] == "leaf":
        return []

    feature = tree["feature"]
    is_numeric = tree["is_numeric"]
    
    # Translate feature names for display if needed
    display_feature = {
        "minat": "Minat",
        "bakat": "Bakat",
        "nilai_akademik": "Nilai Akademik",
        "kepribadian": "Kepribadian"
    }.get(feature, feature)
    
    if is_numeric:
        val = sample.get(feature)
        if val is None:
            return []
        if val <= tree["threshold"]:
            return [f"{display_feature} <= {tree['threshold']:.2f}"] + get_classification_path(tree["left"], sample)
        else:
            return [f"{display_feature} > {tree['threshold']:.2f}"] + get_classification_path(tree["right"], sample)
    else:
        val = str(sample.get(feature))
        if val is None or val not in tree["branches"]:
            return []
        return [f"{display_feature} = '{val}'"] + get_classification_path(tree["branches"][val], sample)

