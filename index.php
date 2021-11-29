<?php function days_between_dates($date1, $date2) {
	$diff = abs(strtotime($date2) - strtotime($date1));

	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

	return $days;
}

$tasks = array(
	"0" => array(
		"task"=>"First task description",
		"start_date"=>"2021-12-04",
		"end_date"=>"2021-12-09"
	),
	"1" => array(
		"task"=>"Second task description",
		"start_date"=>"2021-12-09",
		"end_date"=>"2021-12-10"
	),
	"2" => array(
		"task"=>"Third task description",
		"start_date"=>"2021-12-06",
		"end_date"=>"2021-12-19"
	),
	"3" => array(
		"task"=>"Fourth task description",
		"start_date"=>"2021-12-09",
		"end_date"=>"2021-12-15"
	),
);

$master_start_date = '1970-01-01';
$master_end_date = date('Y-m-d');

$i = 0;
if (is_array($tasks)) {
	foreach ($tasks as $t) {
		$i++;
		if ($i == 1) {
			$master_start_date = $t['start_date'];
			$master_end_date = $t['end_date'];
		} else {
			if ( days_between_dates($master_start_date, $t['start_date']) < 0) {
				$master_start_date = $t['start_date'];
			}

			if ($t['end_date'] > $master_end_date) {
				$master_end_date = $t['end_date'];
			}			
		}
	}

}

$total_blocks = days_between_dates($master_start_date, $master_end_date);

?>
<!DOCTYPE html>
<head>
	<title>Gantt Chart using PHP and BootStrap tables</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<h1 class="mb-3"> Gantt Chart</h1>
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Task</th>
								<th>Duration (days)</th>
								<?php $i = 0;
								while ($total_blocks >= $i) { 
									$k = $i;
									$i++; ?> 
									<th><?= date('M d', strtotime($master_start_date. ' + '.$k.' days')); ?></th>
								<?php } ?>	
							</tr>
						</thead>

						<tbody>
							<?php if (is_array($tasks)) {
								foreach ($tasks as $t) {
									$duration = days_between_dates($t['start_date'], $t['end_date']);
									$start_after_blocks = days_between_dates($master_start_date, $t['start_date']);
									$remaining_blocks = $total_blocks - $duration - $start_after_blocks;
									?>
									<tr>
										<td><?= $t['task'] ?></td>
										<td><?= $duration + 1 ?></td>
										<?php $i = 0;
										while ($start_after_blocks > $i) { 
											$i++; ?> 
											<td></td>
										<?php } ?>

										<?php $i = 0;
										while ($duration >= $i) { 
											$i++; ?> 
											<td style="background-color:green;"></td>
										<?php } ?>


										<?php $i = 0;
										while ($remaining_blocks > $i) { 
											$i++; ?> 
											<td></td>
										<?php } ?>	
									</tr>
									<?php 
								}
							} ?>
						</tbody>

						
					</table>
				</div>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>