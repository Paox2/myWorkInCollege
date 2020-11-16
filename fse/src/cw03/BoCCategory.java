import java.math.BigDecimal;

public class BoCCategory {
	private String CategoryName;
	private BigDecimal CategoryBudget;
	private BigDecimal CategorySpend;

	public BoCCategory() {
		CategoryName = "New Category";
		CategoryBudget = new BigDecimal("0.00");
		CategorySpend = new BigDecimal("0.00");
	}

	public BoCCategory(String newTitle) throws Exception{
		if (newTitle == null) {
			throw new Exception("Cannot set to null"); 
		}
		CategoryName = newTitle;
		if(newTitle.length() > 15) {
			throw new Exception("String too long");
		}
		CategoryBudget = new BigDecimal("0.00");
		CategorySpend = new BigDecimal("0.00");
	}

	public String CategoryName() {
		return CategoryName;	}

	public BigDecimal CategoryBudget() {
		return CategoryBudget;
	}

	public BigDecimal CategorySpend() {
		return CategorySpend;
	}

	public void setCategoryName(String newName) throws Exception {
		if(CategoryName == "Unknown") {
			throw new Exception("Unknown category cannot modify name");
		}
		
		CategoryName = newName;
		if (newName == null) {
			throw new Exception("Cannot set to null"); 
		}
		if(newName.length() > 15) {
			throw new Exception("String too long");
		}
	}

	public void setCategoryBudget(BigDecimal newValue) {
		// 1 means bigger, -1 means smaller, 0 means same
		if (newValue.compareTo(new BigDecimal("0.00")) == 1) {
			CategoryBudget = newValue;
		}
	}

	public void addExpense(BigDecimal valueToAdd) {
		CategorySpend = CategorySpend.add(valueToAdd);
	}

	public void removeExpense(BigDecimal valueToRemove) {
		CategorySpend = CategorySpend.subtract(valueToRemove);
	}

	public void resetBudgetSpend() {
		CategorySpend = new BigDecimal("0.00");
	}

	public BigDecimal getRemainingBudget() {
		BigDecimal remainingBudget = CategoryBudget.subtract(CategorySpend);
		return remainingBudget;
	}

	@Override
	public String toString() {
		if (getRemainingBudget().compareTo(new BigDecimal("0.00")) > -1)
			return "[" + CategoryName + "]" + "(Budget: ¥" + CategoryBudget.toPlainString() + ") - ¥" + CategorySpend.toPlainString()
				+ " (¥" + getRemainingBudget().toPlainString() + " Remaining)";
		else
			return "[" + CategoryName + "]" + "(Budget: ¥" + CategoryBudget.toPlainString() + ") - ¥" + CategorySpend.toPlainString()
			+ " (¥" + getRemainingBudget().abs().toPlainString() + " Overspent)";
	}

}
