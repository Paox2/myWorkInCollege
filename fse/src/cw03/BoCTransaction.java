import java.math.BigDecimal;
import java.util.Date;

public class BoCTransaction {
	private String transactionName;
	private BigDecimal transactionValue;
	private int transactionCategory;
	private Date transactionTime;
	
	public BoCTransaction() {
		transactionName = null;
		transactionValue = null;
		transactionCategory = 0;
		transactionTime = null;
	}

	public BoCTransaction(String tName, BigDecimal tValue, int tCat) {
		if (tName == null) {
			transactionName = null;
		} else if (tName.length() > 25) {
			transactionName = tName.substring(0,25);
		} else {
			transactionName = tName;
		}
		transactionValue = tValue;
		transactionCategory = tCat;
		transactionTime = new Date();
	}

	public String transactionName() {
		return transactionName;
	}

	public BigDecimal transactionValue() {
		return transactionValue;
	}

	public int transactionCategory() {
		return transactionCategory;
	}

	public Date transactionTime() {
		return transactionTime;
	}

	public void setTransactionName(String tName) throws Exception {
		if (tName==null) {
			throw new Exception("Name cannot set to null");
		} else {
			if (isComplete() == 1 || isComplete() == 3) {
				throw new Exception("Name cannot be set");
			} else if (tName.length() > 25) {
				transactionName = tName.substring(0,25);
			} else{
				transactionName = tName;
			}
		}
	}

	public void setTransactionValue(BigDecimal tValue) throws Exception {
		if (isComplete() == 2 || isComplete() == 1) {
			throw new Exception("Value cannot be set");
		}else if (tValue == null) {
			throw new Exception("Can not be set to null");
		}else if (tValue.compareTo(new BigDecimal("0")) ==-1 ) {
			throw new Exception("Value should be positive");
		} else {
			transactionValue = tValue;
		}
	}

	public void setTransactionCategory(int tCat) throws Exception {
		if (tCat >= 0) {
			transactionCategory = tCat;
		} else {
			throw new Exception("Category cannot be negative");
		}
	}

//	public void setTransactionTime(Date tTime) {
//		if (tTime != null) {
//			transactionTime = tTime;
//		}
//	}
	
	public int isComplete() {
		if(transactionName==null && transactionValue == null)
			return 0;
		else if (transactionName==null && transactionValue != null )
			return 2;
		else if (transactionValue==null &&transactionName!=null)
			return 3;
		else 
			return 1;
	}

	@Override
	public String toString() {
		String result = "";
		if (transactionName == null)
			result += "unset";
		else
			result += transactionName;
			
		result += " - ¥";
		
		if (transactionValue == null)
			result += " unset ";
		else
			result += transactionValue;
		
		result += " date: " ;
		
		if (transactionTime == null)
			result += " unset ";
		else
			result += transactionTime.toString();
		return result;
	}

}
