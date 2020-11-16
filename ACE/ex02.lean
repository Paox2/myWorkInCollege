/-
COMP2009-ACE

Exercise 02 (Propositional logic)

   We play the game of logic poker :-)

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
    (i.e. assume, exact, apply, constructor, cases, left, right, have, trivial)

    Please only use the tactics in the way indicated in the script,
    otherwise you may lose upto 2 style points. 

    For propositions classified into c) just keep "sorry," as the proof.
-/

-- Wendi Han   20126355

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

theorem e01 : (P → Q) → (R → P) → (R → Q) :=    -- a. provable intuitionistically
begin
  assume pq rp r,
  apply pq,
  apply rp,
  exact r,
end


theorem e02 : (P → Q) → (P → R) → (Q → R) :=    -- c. not provable classically
begin
  sorry,
end

theorem e03 : (P → Q) → (Q → R) → (P → R) :=    -- a. provable intuitionistically
begin
  assume pq qr p,
  apply qr,
  apply pq,
  exact p,
end

theorem e04 : P → (P → Q) → P ∧ Q :=            -- a. provable intuitionistically
begin
  assume p pq,
  constructor,
  exact p,

  apply pq,
  exact p,
end

theorem e05 : P ∨ Q → (P → Q) → Q :=            -- a. provable intuitionistically
begin
  assume porq pq,
  cases porq with p q,
  apply pq,
  exact p,
  exact q,
end


theorem e06 : (P → Q) → ¬ P ∨ Q :=            -- b. provable classically
begin
  assume pq,
  cases (em P) with p np,
  right,
  apply pq,
  exact p,

  left,
  exact np,
end


theorem e07 : (¬ P ∨ Q) → P → Q :=      -- a. provable intuitionistically
begin
  assume nporq p,
  cases nporq with np q,
  have f: false,
    apply np,
    exact p,
  cases f,
  exact q,
end


theorem e08 : ¬ (P ↔ ¬ P) :=            -- a. provable intuitionistically
begin
  assume h,
  cases h with pnp npp,
  apply pnp,
  apply npp,
  assume p,
  apply pnp,
  exact p,
  exact p,
  
  apply npp,
  assume p,
  apply pnp,
  exact p,
  exact p,
end


theorem e09 : ¬ P ↔ ¬ ¬ ¬ P :=            -- a. provable intuitionistically
begin
  constructor,
  assume np nnp,
  apply nnp,
  exact np,

  assume nnnp p,
  apply nnnp,
  assume np,
  apply np,
  exact p,
end


theorem e10 : ((P → Q) → P) → P :=            -- b. provable classically
begin
  assume pqp,
  cases (em P) with p np,
  exact p,

  apply pqp,
  assume p,
  have f: false,
  apply np,
  exact p,
  cases f,
end