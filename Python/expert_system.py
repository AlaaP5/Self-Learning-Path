from experta import *

class WeakConcept(Fact):
    concept_id = Field(int, mandatory=True)
    error_rate = Field(float, mandatory=True)

class ConceptPrerequisite(Fact):
    concept_id = Field(int, mandatory=True)
    requires = Field(int, mandatory=True)

class LearningAdvice(Fact):
    concept_id = Field(int, mandatory=True)
    priority = Field(int, mandatory=True)

class StudentAnalysisEngine(KnowledgeEngine):
    @Rule(
        WeakConcept(
            concept_id=MATCH.cid,
            error_rate=P(lambda x: x >= 66.0)
        ),
        ConceptPrerequisite(
            concept_id=MATCH.cid,
            requires=MATCH.req
        )
    )
    def suggest_prerequisite(self, cid, req):
        self.declare(LearningAdvice(concept_id=req, priority=1))
        self.declare(LearningAdvice(concept_id=cid, priority=2))

    @Rule(
        WeakConcept(
            concept_id=MATCH.cid,
            error_rate=P(lambda x: x >= 66.0)
        ),
        NOT(ConceptPrerequisite(concept_id=MATCH.cid))
    )
    def suggest_direct_study(self, cid):
        self.declare(LearningAdvice(concept_id=cid, priority=1))

def analyze_student_weaknesses(weak_concepts, prerequisites):
    engine = StudentAnalysisEngine()
    engine.reset()

    for wc in weak_concepts:
        engine.declare(WeakConcept(
            concept_id=wc['id'],
            error_rate=wc['error_rate']
        ))

    for pr in prerequisites:
        engine.declare(ConceptPrerequisite(
            concept_id=pr['concept_id'],
            requires=pr['requires']
        ))

    engine.run()

    learning_path = []
    for fact in engine.facts:
        if isinstance(fact, LearningAdvice):
            learning_path.append({
                'concept_id': fact['concept_id'],
                'priority': fact['priority']
            })

    return sorted(learning_path, key=lambda x: x['priority'])


if __name__ == "__main__":
    import sys
    import json

    try:
        weak_concepts = json.loads(sys.argv[1])
        prerequisites = json.loads(sys.argv[2])

        result = analyze_student_weaknesses(weak_concepts, prerequisites)

        print(json.dumps(result))

    except Exception as e:
        print(json.dumps({"error": str(e)}))
