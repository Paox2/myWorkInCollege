/-
COMP2009-ACE

Exercise 03 (Predicate logic)

    This exercise has 2 parts. In the 1st part you are supposed to
    formally define what certain relation bewteen humans are (like
    Father, brother-in-law etc). Here we use Lean only as a syntax  and type checker. 
    In the 2nd part we play logic poker again :-) but this time for
    predicate logic. 
-/


-- Wendi Han 20126355


namespace family

-- Given the following type, predicates and relations:

constant People : Type
constants Male Female : People → Prop
-- Male x means x is male
-- Female x means x is fmeale
constant Parent : People → People → Prop
-- Parent x y means x is a parent of y
constant Married : People → People → Prop
-- Married x y means x is married to y

/-
Define the following relations (People → People → Prop) 
using the predicates and relations above:

- Father x y = x is the father of y
- Brother x y = x is the brother of y
- Grandmother x y = x is the grandmother of y
- FatherInLaw x y = x is the father-in-law of y
- SisterInLaw x y = x is the sister in law of y
- Uncle x y = x is the uncle of y

If you are not sure about the definition of these terms, check them 
in wikipedia. If there is more than one option choose one.
-/

/- As an example: here is the definition of Father: -/

def Father (x y : People) : Prop
  := Parent x y ∧ Male x

-- insert your definitions here


-- A sibling is a gender neutral word for a relative that shares at least one parent with the subject.
def Sibling (x y : People) : Prop
  := ∃ z : People, Parent z y ∧ Parent z x

def Brother (x y : People) : Prop
  := Sibling x y ∧ Male x

def Grandmother (x y : People) : Prop
  := (∃ z : People, Parent x z ∧ Parent z y) ∧ Female x

def FatherInLaw (x y : People) : Prop
  := (∃ z : People, Father x z ∧ Married z y) ∧ Male x

def SisterInLaw (x y : People) : Prop
  :=  Female x ∧ ((∃ z : People, Sibling x z ∧ Married z y)
                  ∨ (∃ z :People, Sibling z y ∧ Married x z))

def Uncle (x y : People) : Prop
  := (∃ z : People, Parent z y ∧ Brother x z) 
      ∨ (∃ z : People, Parent z y ∧ (∃ a : People, Sibling a z ∧ Married a x) ∧ Male x)

end family

namespace poker
/-
   We play the game of logic poker - but this time with predicate logic :-)

    You have to classify the propositions into
    a) provable intuitionistically (i.e. in plain lean)
    b) provable classically (using em : P ∨ ¬ P or raa : ¬¬ P → P).
    c) not provable classically.
    and then you have to prove the propositions in a) and b) accordingly.

    Here is how you score:
    We start with 10 points :-)
    For any proposition which you didn't classify correctly (or not at all)
    you loose 1 point. :-(
    For any proposition which is provable but you didn't prove you loose
    1 point. :-(
    We stop subtracting points at 0. :-)

    Write the classification as a comment using -- after the proposition.

     You are only allowed to use the tactics introduced in the lecture
    (i.e. assume, exact, apply, constructor, cases, left, right, have, 
    trivial, existsi, reflexivity, rewrite)

    Please only use the tactics in the way indicated in the script,
    otherwise you may lose upto 2 style points. 

    For propositions classified into c) just keep "sorry," as the proof.
-/
variable A : Type
variables PP QQ : A → Prop
variables RR : A → A → Prop
variables P Q R : Prop

open classical

theorem raa : ¬ ¬ P → P := 
begin
  assume nnp,
  cases (em P) with p np,
    exact p,
    have f : false,
      apply nnp,
      exact np,
    cases f,
end

theorem ex01 : (∀ x:A, ∃ y : A , RR x y) → (∃ y : A, ∀ x : A, RR x y) :=
-- c) not provable classically
begin 
  sorry,
end

theorem ex02 :  (∃ y : A, ∀ x : A, RR x y) → (∀ x:A, ∃ y : A , RR x y) :=
-- a) provable intuitionistically
begin 
  assume h,
  cases h with y r,
  assume x,
  existsi y,
  apply r,
end

theorem ex03 : ∀ x y : A, x = y → RR x y → RR x x :=
-- a) provable intuitionistically
begin 
  assume x y,
  assume h,
  rewrite h,
  assume r,
  exact r,
end

theorem ex04 : ∀ x y z : A, x ≠ y → x ≠ z → y ≠ z :=
-- c) not provable classically.
begin 
  sorry,
end

theorem ex05 : ∀ x y z : A, x = y → x ≠ z → y ≠ z :=
-- a) provable intuitionistically
begin 
  assume x y z,
  assume h a,
  rewrite<- h,
  exact a,
end

theorem ex06 : ∀ x y z : A, x ≠ y → (x ≠ z ∨ y ≠ z) :=
-- b) provable classically
begin 
  assume x y z,
  assume h,
  cases (em (y=z)) with a b,
  left,
  rewrite<- a,
  exact h,
  right,
  exact b,
end

theorem ex07 : ¬ ¬ (∀ x : A, PP x) → ∀ x : A, ¬ ¬ PP x :=
-- a) provable intuitionistically
begin 
  assume nnh x np,
  apply nnh,
  assume p,
  apply np,
  apply p,
end

theorem ex08 : (∀ x : A, ¬ ¬ PP x) → ¬ ¬ ∀ x : A, PP x :=
-- b) provable classically
begin 
  assume h,
  assume np,
  apply np,
  assume x,
  apply raa,
  apply h,
end

theorem ex09 : (∃ x : A, true) → (∃ x:A, PP x) → ∀ x : A,PP x :=
-- c) not provable classically.
begin 
  sorry,
end

theorem ex10 : (∃ x : A, true) → (∃ x:A, PP x → ∀ x : A,PP x) :=
-- b) provable classically
begin 
  cases (em (∀ x : A, PP x)) with p np,
  assume h,
  cases h with x t,
  existsi x,
  assume ppx,
  exact p,
  assume h,
  have f : ∃ x : A, ¬ PP x,
  apply raa,
  assume n,
  apply np,
  assume x,
  apply raa,
  assume npp,
  apply n,
  existsi x,
  exact npp,

  cases f with x npx,
  existsi x,
  assume p,
  have f : false,
  apply npx,
  exact p,
  cases f,
end

end poker