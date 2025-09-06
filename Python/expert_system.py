from experta import *
import numbers
import json


class WeakConcept(Fact):
    concept_id = Field(int, mandatory=True)
    error_rate = Field(numbers.Real, mandatory=True)


class ConceptPrerequisite(Fact):
    concept_id = Field(int, mandatory=True)
    requires = Field(int, mandatory=True)


class StudentAnalysisEngine(KnowledgeEngine):
    def __init__(self):
        super().__init__()
        self.learning_paths = []
        self.path_counter = 1

    def new_path(self):
        path_id = self.path_counter
        self.path_counter += 1
        return path_id

    @Rule(
        WeakConcept(
            concept_id=MATCH.cid,
            error_rate=P(lambda x: x >= 66.0)
        ),
        NOT(ConceptPrerequisite(concept_id=MATCH.cid)),
        salience=10
    )
    def suggest_direct_study(self, cid):
        path_id = self.new_path()
        self.learning_paths.append({"path_id": path_id, "concept_id": cid, "priority": 1})

    @Rule(
        WeakConcept(
            concept_id=MATCH.cid,
            error_rate=P(lambda x: x >= 66.0)
        ),
        ConceptPrerequisite(
            concept_id=MATCH.cid,
            requires=MATCH.req
        ),
        salience=5
    )
    def suggest_prerequisite(self, cid, req):
        path_id = self.new_path()
        self.learning_paths.append({"path_id": path_id, "concept_id": req, "priority": 1})
        self.learning_paths.append({"path_id": path_id, "concept_id": cid, "priority": 2})


def analyze_student_weaknesses(weak_concepts, prerequisites):
    engine = StudentAnalysisEngine()
    engine.reset()

    for wc in weak_concepts:
        engine.declare(WeakConcept(
            concept_id=int(wc['id']),
            error_rate=float(wc['error_rate'])
        ))

    for pr in prerequisites:
        engine.declare(ConceptPrerequisite(
            concept_id=int(pr['concept_id']),
            requires=int(pr['requires'])
        ))

    engine.run()

    return engine.learning_paths


if __name__ == "__main__":
    import sys

    try:
        weak_concepts = json.loads(sys.argv[1])
        prerequisites = json.loads(sys.argv[2])

        result = analyze_student_weaknesses(weak_concepts, prerequisites)

        print(json.dumps(result, ensure_ascii=False))
    except Exception as e:
        print(json.dumps({"error": str(e)}))
