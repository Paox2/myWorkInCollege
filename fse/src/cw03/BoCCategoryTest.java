import static org.junit.jupiter.api.Assertions.*;

import java.math.BigDecimal;
import org.junit.jupiter.api.BeforeAll;
import org.junit.jupiter.api.MethodOrderer;
import org.junit.jupiter.api.Order;
import org.junit.jupiter.api.Test;
import org.junit.jupiter.api.TestMethodOrder;

import org.junit.Ignore;

@TestMethodOrder(MethodOrderer.OrderAnnotation.class)

class BoCCategoryTest {
	
	
	static String CategoryName;
	static BigDecimal CategoryBudget;
	static BigDecimal CategorySpend;
	static BigDecimal newBudget1;
	static BigDecimal newBudget2;
	static BigDecimal newBudget3;
	static BigDecimal valueToAdd;
	static BigDecimal valueToAdd1;
	static BigDecimal valueToRemove;
	static BoCCategory Cat0;
	static BoCCategory Cat1;
	static BoCCategory Cat2;
	static BoCCategory Cat3;
	static String newTitle1;
	static String newTitle2;
	static String newName1;
	static String newName2;
	static String newName3;

	@BeforeAll
	static void setup() {
		
		Cat2 = new BoCCategory();
		Cat3 = new BoCCategory();
		CategoryName = "New Category";
		CategoryBudget = new BigDecimal("0.00");
		CategorySpend = new BigDecimal("0.00");
		newTitle1 = "Groceries";
		newTitle2 = "aNameOver25WordsWhichShouldBeInvalid";
		newName1 = "Unknown";
		newName2 = "aNameOver25WordsWhichShouldBeInvalid";
		newName3= "newName";
		newBudget1 = new BigDecimal("99.00");
		newBudget2 = new BigDecimal("0.00");
		newBudget3 = new BigDecimal("-55.00");
		valueToAdd = new BigDecimal("88.00");
		valueToAdd1 = new BigDecimal("888.00");
		valueToRemove = new BigDecimal("8.00");
		
		System.out.println("initial successful");
	}
	
	@Test
	@Order(1)
	void testBoCCategory1() {
		Cat0 = new BoCCategory();
		assertEquals("New Category",Cat0.CategoryName());
		assertEquals(CategoryBudget,Cat0.CategoryBudget());
		assertEquals(CategorySpend,Cat0.CategorySpend());
	}
	
	@Test
	@Order(2)
	void testBoCCategory2() throws Exception {
		Cat1 = new BoCCategory(newTitle1);
		assertEquals(newTitle1,Cat1.CategoryName());
		assertEquals(CategoryBudget,Cat1.CategoryBudget());
		assertEquals(CategorySpend,Cat1.CategorySpend());
	}
	
	@Ignore //Old test without known exception
	void testBoCCategory3Before() {
		try {
			Cat1 = new BoCCategory(newTitle2);
		} catch(Exception e) { 
			return;			
		}
		fail("It failed");
	}
	
	@Test
	@Order(3)
	void testBoCCategory3() {
		Exception e = assertThrows(Exception.class, () -> {
			Cat1 = new BoCCategory(newTitle2);
		});
		assertEquals("String too long", e.getMessage());
	}
	
	@Test
	@Order(4)
	void testCategoryName() {
		assertEquals(CategoryName,Cat3.CategoryName());
	}
	
	@Test
	@Order(5)
	void testCategoryBudget() {
		assertEquals(CategoryBudget,Cat3.CategoryBudget());
	}
	
	@Test
	@Order(6)
	void testCategorySpend() {
		assertEquals(CategorySpend,Cat3.CategorySpend());
	}
	
	@Test
	@Order(7)
	void testSetCategoryName1() throws Exception {
		Cat2.setCategoryName(newName1);
		assertEquals(newName1,Cat2.CategoryName());
	}
	
	@Ignore //Old test without known exception
	void testSetCategoryName2Before() {	
		try {
			Cat2.setCategoryName(newName3);
		} catch(Exception e) { 
			return;			
		}
		fail("It failed");
	}
	
	@Test
	@Order(8)
	void testSetCategoryName2() {	
		Exception e = assertThrows(Exception.class, () -> {
			Cat2.setCategoryName(newName3);
		});
		assertEquals("Unknown category cannot modify name", e.getMessage());
	}
	
	@Ignore //Old test without known exception
	void testSetCategoryName3Before() {
		try {
			Cat1.setCategoryName(newName2);
		} catch(Exception e) { 
			return;			
		}
		fail("It failed");
	}
	
	@Test
	@Order(9)
	void testSetCategoryName3() {
		Exception e = assertThrows(Exception.class, () -> {
			Cat1.setCategoryName(newName2);
		});
		assertEquals("String too long", e.getMessage());
	}
	
	@Test
	@Order(10)
	void testSetCategoryBudget1() {
		Cat2.setCategoryBudget(newBudget1);
		assertEquals(newBudget1,Cat2.CategoryBudget());
	}
	
	@Test
	@Order(11)
	void testSetCategoryBudget2() {
		BigDecimal Budget = Cat2.CategoryBudget();
		Cat2.setCategoryBudget(newBudget2);
		assertEquals(Budget,Cat2.CategoryBudget());
	}
	
	@Test
	@Order(12)
	void testAddExpense() {
		BigDecimal value = Cat2.CategorySpend().add(valueToAdd);
		Cat2.addExpense(valueToAdd);
		assertEquals(value,Cat2.CategorySpend());
	}
	
	@Test
	@Order(13)
	void testRemoveExpense() {
		BigDecimal value = Cat2.CategorySpend().subtract(valueToRemove);
		Cat2.removeExpense(valueToRemove);
		assertEquals(value,Cat2.CategorySpend());
	}
	
	@Test
	@Order(14)
	void testResetBudgetSpend() {
		Cat2.resetBudgetSpend();
		CategorySpend = new BigDecimal("0.00");
		assertEquals(CategorySpend,Cat2.CategorySpend());
	}
	
	@Test
	@Order(15)
	void testGetRemainingBudget() {
		BigDecimal value = Cat2.CategoryBudget().subtract(Cat2.CategorySpend());
		assertEquals(value,Cat2.getRemainingBudget());
	}
	
	@Test
	@Order(16)
	void testToString1() {
		String nameString = Cat2.CategoryName(); 
		String budgetString = Cat2.CategoryBudget().toPlainString(); 
		String spendString	= Cat2.CategorySpend().toPlainString();
		String remainString = Cat2.getRemainingBudget().toPlainString(); 
		String catToString = "[" + nameString + "]" +"(Budget: ¥" + budgetString + ") - ¥" + spendString + " (¥" + remainString + " Remaining)";
		assertEquals(catToString,Cat2.toString());
	}
	
	@Test
	@Order(17)
	void testToString2() {
		Cat2.addExpense(valueToAdd1);
		String nameString = Cat2.CategoryName(); 
		String budgetString = Cat2.CategoryBudget().toPlainString(); 
		String spendString	= Cat2.CategorySpend().toPlainString();
		String remainString = Cat2.getRemainingBudget().abs().toPlainString(); 
		String catToString = "[" + nameString + "]" +"(Budget: ¥" + budgetString + ") - ¥" + spendString + " (¥" + remainString + " Overspent)";
		assertEquals(catToString,Cat2.toString());
	}
	
	@Ignore //Old test without known exception
	void testBoCCategory4Before() {
		try {
			BoCCategory Cat4 = new BoCCategory(null);
		} catch(Exception e) { 
			return;			
		}
		fail("It failed");
	}
	
	@Test
	@Order(18)
	void testBoCCategory4() throws Exception {
		Exception e = assertThrows(Exception.class, () -> {
			BoCCategory Cat4 = new BoCCategory(null);
		});
		assertEquals("Cannot set to null", e.getMessage());
	}

	@Ignore //Old test without known exception
	void testSetCategoryName4Before() {
		try {
			Cat1.setCategoryName(null);
		} catch(Exception e) { 
			return;			
		}
		fail("It failed");
	}
	
	@Test
	@Order(19)
	void testSetCategoryName4() throws Exception {
		Exception e = assertThrows(Exception.class, () -> {
			Cat1.setCategoryName(null);
		});
		assertEquals("Cannot set to null", e.getMessage());
	}
}