var fieldset_id = "fee_fieldset_repeat";
var row_basename = "fee_row";
var row_count;
var next_row_index;

function initFeeTable(rows) {
	row_count = rows;
	next_row_index = row_count + 1;
}

function addFeeRow() {
	var fieldset = document.getElementById(fieldset_id);
	var templateNode = document.getElementById("fee_row_template");
	var newNode;
	
	if (fieldset && templateNode) {
		newNode = templateNode.cloneNode(false);
		newNode.id = row_basename + "[" + next_row_index + "]";
		newNode.innerHTML = templateNode.innerHTML.replace(/%index%/g, next_row_index);
		fieldset.appendChild(newNode);

		// Set focus
		document.getElementById("fee_loc[" + next_row_index + "]").focus();

		next_row_index++;
		row_count++;
		
		if (row_count == 1) {
			// Update default prompt.
			document.getElementById("all_cities").style.display = "none";
			document.getElementById("other_cities").style.display = "block";
		}
	}
}

function removeFeeRow(index) {
	var row = document.getElementById(row_basename + "[" + index + "]");
	if (row) {
		row.parentNode.removeChild(row);
		row_count--;
		
		if (row_count == 0) {
			// Update default prompt.
			document.getElementById("all_cities").style.display = "block";
			document.getElementById("other_cities").style.display = "none";
		}
	}
}
