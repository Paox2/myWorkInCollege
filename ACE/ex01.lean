/- id: 20126355  full name: Wendi Han -/

variables P Q R : Prop

theorem e01 : P → Q → P :=
begin
  assume p,
  assume q,
  exact p,
end

theorem e02 : (P → Q → R) → (P → Q) → P → R :=
begin
  assume pqr pq p,
  apply pqr,
  exact p,
  apply pq,
  exact p,
end

theorem e03 : (P → Q) → P ∧ R → Q ∧ R :=
begin
  assume pq pr,
  cases pr with p r,
  constructor,
  apply pq,
  exact p,
  exact r,
end

theorem e04 : (P → Q) → P ∨ R → Q ∨ R :=
begin
  assume pq pr,
  cases pr with p r,
  left,
  apply pq,
  exact p,
  right,
  exact r,
end

theorem e05 : P ∨ Q → R ↔ (P → R) ∧ (Q → R) :=
begin
  constructor,
  assume lhs,
  constructor,

  assume p,
  apply lhs,
  left,
  exact p,

  assume q,
  apply lhs,
  right,
  exact q,

  assume rhs pq,
  cases rhs with pr qr,
  cases pq with p q,
  apply pr, 
  exact p,
  apply qr, 
  exact q,
end

theorem e06 : P → ¬ ¬ P :=
begin
  assume p,
  assume np,
  apply np,
  exact p,
end

theorem e07 : P ∧ true ↔ P :=
begin
  constructor,
  assume pt,
  cases pt with p t,
  exact p,

  assume p,
  constructor,
  exact p,
  trivial,
end

theorem e08 : P ∨ false ↔ P :=
begin
  constructor,
  assume pf,
  cases pf with p f,
  exact p,
  cases f,

  assume p,
  left,
  exact p,
end

theorem e09 : P ∧ false ↔ false :=
begin
  constructor,
  assume pf,
  cases pf with p f,
  exact f,

  assume f,
  cases f,
end

theorem e10 : P ∨ true ↔ true :=
begin
  constructor,
  assume pt,
  trivial,
  
  assume p,
  right,
  trivial,
end