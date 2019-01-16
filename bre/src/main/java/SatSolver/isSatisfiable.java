package SatSolver;

public class isSatisfiable {

	private String CNF;
	private boolean isCNF;

	public isSatisfiable(String CNF, boolean isCNF) {

		this.CNF = CNF;
		this.isCNF = isCNF;
	}

	public boolean isCNFSatisfiable() {

		if (isCNF) {
			DPSolver solver = new DPSolver();
			return solver.solve(CNF);
		}
		//System.out.println("The formula is unsatisfiable!");
		return false;
	}

}

