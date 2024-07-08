<form id="addTransactionForm" action="index.php" method="post">
    <div class="form-group">
        <label for="member_id">Member ID:</label>
        <input type="text" class="form-control" id="member_id" name="member_id" required>
    </div>
    <div class="form-group">
        <label for="transaction_date">Transaction Date:</label>
        <input type="date" class="form-control" id="transaction_date" name="transaction_date" required>
    </div>
    <div class="form-group">
        <label for="amount">Amount:</label>
        <input type="text" class="form-control" id="amount" name="amount" required>
    </div>
    <button type="submit" class="btn btn-primary" name="add_transaction">Add Transaction</button>
</form>
