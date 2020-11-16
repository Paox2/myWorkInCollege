import java.math.BigDecimal;
import java.util.ArrayList;
import java.util.Scanner;

public class BoCApp {
	public static ArrayList<BoCTransaction> UserTransactions;
	public static ArrayList<BoCCategory> UserCategories;

	public static void main(String[] args) throws Exception {
		UserCategories = new ArrayList<BoCCategory>();
		UserTransactions = new ArrayList<BoCTransaction>();
		
		try {
			// SETUP EXAMPLE DATA //
			UserCategories.add(new BoCCategory("Unknown"));
			BoCCategory BillsCategory = new BoCCategory("Bills");
			BillsCategory.setCategoryBudget(new BigDecimal("120.00"));
			UserCategories.add(BillsCategory);
			BoCCategory Groceries = new BoCCategory("Groceries");
			Groceries.setCategoryBudget(new BigDecimal("75.00"));
			UserCategories.add(Groceries);
			BoCCategory SocialSpending = new BoCCategory("Social");
			SocialSpending.setCategoryBudget(new BigDecimal("100.00"));
			UserCategories.add(SocialSpending);
	
			UserTransactions.add(new BoCTransaction("Rent", new BigDecimal("850.00"), 0));
			UserTransactions.add(new BoCTransaction("Phone Bill", new BigDecimal("37.99"), 1));
			UserTransactions.add(new BoCTransaction("Electricity Bill", new BigDecimal("75.00"), 1));
			UserTransactions.add(new BoCTransaction("Sainsbury's Checkout", new BigDecimal("23.76"), 2));
			UserTransactions.add(new BoCTransaction("Tesco's Checkout", new BigDecimal("7.24"), 2));
			UserTransactions.add(new BoCTransaction("RockCity Drinks", new BigDecimal("8.50"), 3));
			UserTransactions.add(new BoCTransaction("The Mooch", new BigDecimal("13.99"), 3));
		} catch(Exception e) {
			System.out.println(e.toString());
			return;
		}
			
		for (int x = 0; x < UserTransactions.size(); x++) {
			BoCTransaction temp = UserTransactions.get(x);
			int utCat = temp.transactionCategory();
			BoCCategory temp2 = UserCategories.get(utCat);
			temp2.addExpense(temp.transactionValue());
			UserCategories.set(utCat, temp2);
		}

		// MAIN FUNCTION LOOP

		CategoryOverview();
		System.out.println(
				"\nWhat do you want to do?\n O = [O]verview, T = List All [T]ransactions, [num] = Show Category [num], C = [C]hange Transaction Category, A = [A]dd Transaction, N = [N]ew Category, X = E[x]it");
		Scanner in = new Scanner(System.in);
		while (in.hasNextLine()) {
			String s = in.next();
			try {
				if (s.equals("T")) {
					ListTransactions();
				} else if (s.equals("O")) {
					CategoryOverview();
				} else if (s.equals("C")) {
					ChangeTransactionCategory(in);
				} else if (s.equals("N")) {
					AddCategory(in);
				} else if (s.equals("A")) {
					AddTransaction(in);
				} else if (s.equals("X")) {
					System.out.println("Goodbye!");
					break;
				} else {
					try {
						int i = Integer.parseInt(s);
						if (i > 0 && i <= UserCategories.size()) {
							ListTransactionsForCategory(i-1);
						} else {
							System.out.println("Category not exist");
						}
					} catch (NumberFormatException e) {
						System.out.println("Command not recognised");
					}
				}
			} catch (Exception e) {
				System.out.println("Something went wrong: " + e.toString());
			}
 
			System.out.println(
					"\nWhat do you want to do?\n O = [O]verview, T = List All [T]ransactions, [num] = Show Category [num], C = [C]hange Transaction Category, A = [A]dd Transaction, N = [N]ew Category, X = E[x]it");
		}
		in.close();
	}

	public static void ListTransactions() {
		for (int x = 0; x < UserTransactions.size(); x++) {
			BoCTransaction temp = UserTransactions.get(x);
			int i = temp.transactionCategory();
			System.out.println((x + 1) + ") " + temp.transactionName() + " (" + UserCategories.get(i).CategoryName() + ") - ¥" + temp.transactionValue().toString());
		}
	}

	public static void CategoryOverview() {
		for (int x = 0; x < UserCategories.size(); x++) {
			BoCCategory temp = UserCategories.get(x);
			System.out.println((x + 1) + ") " + temp.toString());
		}
	}

	public static void ListTransactionsForCategory(int chosenCategory) {
		String chose = UserCategories.get(chosenCategory).CategoryName();
		
		for (int x = 0; x < UserTransactions.size(); x++) {
			BoCTransaction temp = UserTransactions.get(x);
			if (temp.transactionCategory() == chosenCategory) {
				System.out.println((x + 1) + ") " + temp.transactionName() + " (" + chose + ") - ¥" + temp.transactionValue().toString());
			}
		}
	}

	private static void AddTransaction(Scanner in) {
		System.out.println("What is the title of the transaction?");
		in.nextLine(); // to remove read-in bug
		String title = in.nextLine();
		BigDecimal tvalue;
		int tCat;
		while(true) {
			try {
				System.out.println("What is the value of the transaction?");
				tvalue = new BigDecimal(in.nextLine());
				tvalue = tvalue.setScale(2, BigDecimal.ROUND_HALF_UP);
				if (tvalue.compareTo(new BigDecimal("0")) ==-1) {
					System.out.println("Invalid number. Please input a positive number");
					continue;
				}
				break;
			} catch (NumberFormatException e) {
				System.out.println("Invalid number. Please input a valid number");
			}
		}
		while(true) {
			CategoryOverview();
			try {
				System.out.println("What category do you want to add?");
				tCat = Integer.parseInt(in.nextLine());
			} catch (NumberFormatException e) {
				System.out.println("Invalid number. Please input a valid integer");
				continue;
			}
			if (tCat > 0 && tCat <= UserTransactions.size()) {
				break;
			} else {
				System.out.println("Invalid number. Category not exist");
				continue;
			}
		}
		
		BoCTransaction newTran= new BoCTransaction(title, tvalue, (tCat-1));
		
		UserTransactions.add(newTran);
		UserCategories.get(tCat-1).addExpense(tvalue);
		System.out.println("[" + newTran.transactionName() + "](¥" + tvalue +") was added to [" + UserCategories.get(tCat-1).CategoryName() + "]");
	}

	private static void ChangeTransactionCategory(Scanner in) throws Exception {
		int tID;
		in.nextLine();
		while(true) {
			ListTransactions();
			try {
				System.out.println("Which transaction ID?");
				tID = Integer.parseInt(in.nextLine());
			} catch (NumberFormatException e) {
				System.out.println("Invalid number. Please input a valid integer");
				continue;
			}
			if (tID > 0 && tID <= UserTransactions.size()) {
				break;
			} else {
				System.out.println("Invalid number. Transaction not exist");
				continue;
			}
		}
		
		int oldCat = UserTransactions.get(tID - 1).transactionCategory();
		
		System.out.println("\t- " + UserTransactions.get(tID - 1).toString());
		
		int newCat;
		while(true) {
			CategoryOverview();
			try {
				System.out.println("What category do you want to add?");
				newCat = Integer.parseInt(in.nextLine());
			} catch (NumberFormatException e) {
				System.out.println("Invalid number. Please input a valid integer");
				continue;
			}
			if (newCat > 0 && newCat <= UserCategories.size()) {
				break;
			} else {
				System.out.println("Invalid number. Category not exist");
				continue;
			}
		}

		BoCTransaction temp = UserTransactions.get(tID-1);
		temp.setTransactionCategory(newCat-1);
		UserTransactions.set(tID-1, temp);
		BoCCategory temp2 = UserCategories.get(newCat-1);
		temp2.addExpense(temp.transactionValue());
		UserCategories.set(newCat-1, temp2);
		BoCCategory temp3 = UserCategories.get(oldCat);
		temp3.removeExpense(temp.transactionValue());
		UserCategories.set(oldCat, temp3);
		
		System.out.println(temp2.toString());
		System.out.println(temp3.toString());
	}

	private static void AddCategory(Scanner in) throws Exception {
		in.nextLine();
		while(true) {
			try {
				System.out.println("What is the title of the category?");
				String title = in.nextLine();
		
				BoCCategory temp;
				temp = new BoCCategory(title);
				
				BigDecimal cbudget;
				while(true) {
					try {
						System.out.println("What is the budget for this category?");
						cbudget = new BigDecimal(in.nextLine());
						cbudget = cbudget.setScale(2, BigDecimal.ROUND_HALF_UP);
						temp.setCategoryBudget(cbudget);
						break;
					} catch (NumberFormatException e) {
						System.out.println("Invalid number. Please input a valid number");
						continue;
					}
				}
		
				UserCategories.add(temp);
				System.out.println("[Category added]");
				CategoryOverview();
				break;
			} catch(Exception e) {
				System.out.println(e.getMessage());
			}
		}
	}

}
