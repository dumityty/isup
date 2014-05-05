<?php

/**
 * @file
 * Main monitoring isup pages file.
 *
 */

/*
 * Page to show a client's websites.
 */
function isup_manager_page() {
	global $user;


	$websites_select = db_select('isup_manager', 'im')
		->fields('im')
			// 'uid',
			// 'url',
			// )
		->condition('uid', $user->uid, '=')
		->execute();

	// $websites = $websites_select->fetchAll();

	$output = "";
	$output .= "<b>Manager</b>";

	// check if any websites have been added for the client.
	if ($websites_select->rowCount() == 0) {
		$output .= "<div class='well'>You are not managing any websites.<br />Visit the example page.</div>";
		return $output;
	}

	// $output .= "<table>";
	$output .= "
		<div class='well'>
			<div class='row'>
				<div class='col-sm-3'>
					Title
				</div>
				<div class='col-sm-3'>
					URL
				</div>
				<div class='col-sm-2'>
					Last checked
				</div>
				<div class='col-sm-2'>
					Last down
				</div>
				<div class='col-sm-2'>
					Status
				</div>
			</div>
		</div>
	";
	while ($site = $websites_select->fetchObject()) {
		// dpm($site,'site');
		$output .= "
			<div class='well'>
				<div class='row'>
					<div class='col-sm-3'>" 
					. $site->title . "
					</div>
					<div class='col-sm-3'>" 
					. $site->url . "
					</div>
					<div class='col-sm-2'>" 
					. date('d-m-Y H:i',$site->last_checked) . " 
					</div>
					<div class='col-sm-2'>" 
					. date('d-m-Y H:i',$site->last_down) . "
					</div>
					<div class='col-sm-2'>" 
					. $site->status . "
					</div>
				</div>
			</div>";
		
	}
	// $output .= "</table>";

	// $output .= "<div class='well'>" . $website . " - " . $last_checked . " - " . $last_down . " - " . $status . "</div>";

	return $output;
}