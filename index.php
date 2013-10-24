<?php

include('includes/config.php');

$streaks = new NHL_Streaks();
$streaks->current_season = '2013-2014';

if($_GET['action'] == 'update')
$streaks->update();


?>
<html>
<head>
	<title>NHL - Teams &amp; Players streaks</title>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="./assets/js/nhl-streaks.js"></script>

	<link rel="stylesheet" href='./assets/css/dark-hive/jquery-ui-1.10.3.custom.min.css' type='text/css' media='all' />
	<link rel="stylesheet" href='./assets/css/nhl-streaks.css' type='text/css' media='all' />

</head>
<style type="text/css">
	table {
		font-family:arial;
		font-weight:normal;
		font-size:14px;
	}
	table th {
		font-weight:bold;
		width:80px;
		font-size:140%;
		padding:10px;
		}
		table th.team_name {
			width:200px;
		}
		table th.source .date {
			font-weight:normal;
			font-size:60%;
		}
	table thead tr {
		background-color:#333;
		color:#fff;
		}
		table thead tr a {
			color:#999900;
		}

	table tr.odd {
		background-color:#fff;
	}
	table td {
		padding:10px;
		}
		table td.pos {
			font-size:190%;
		}
		table td.team_name {
			font-size:120%;
		}
		table td.source {
			font-size:190%;
			}
			table td.source span.variation {
				font-size:40%;
			}

</style>
<body>
	<a href="https://github.com/emilegirard/nhl-streaks"><img style="position: absolute; top: 0; left: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_left_darkblue_121621.png" alt="Fork me on GitHub"></a>

	<h1>NHL Team Hot Streaks</h1>
	<ul>
		<li><a href="?ajax=true&action=update">Update Data</a> (last update on <?=$streaks->last_update;?>)</li>
	</ul>

<br /><br /><br />

	<div id="results">

		<table cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th class="pos">Avg. Position</th>
					<th class="team_name">Team Name</th>
					<th class="source">
						<a href="<?=$streaks->content['power_rankings']['tsn']['url'];?>" target="_blank">TSN</a><br />
						<span class="date"><?=$streaks->content['power_rankings']['tsn']['date'];?></span>
					</th>
					<th class="source">
						<a href="<?=$streaks->content['power_rankings']['espn']['url'];?>" target="_blank">ESPN</a><br />
						<span class="date"><?=$streaks->content['power_rankings']['espn']['date'];?></span>
					</th>
					<th class="comments">Comments</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$i=1;
					foreach($streaks->content['power_rankings']['averages'] as $team_abbr=>$team) :
						if(!isset($cur_pos_avg)) $cur_pos_avg = $team['average_w'];
						if($team['average_w'] == $cur_pos_avg) $same_avg_counter++; else $same_avg_counter=0;
						?>
						<tr class="<?=($i%2 === 0) ? 'odd' : ''; ?>">
							<td class="pos"><?php if($same_avg_counter < 1 || $i==1) echo $i;?></td>
							<td class="team_name"><?=$team['team_name'];?></td>
							<td class="source"><?=$team['sources']['tsn']['pos_w'];?> <span class="variation"><?=$team['sources']['tsn']['pos_diff'];?></span></td>
							<td class="source"><?=$team['sources']['espn']['pos_w'];?> <span class="variation"><?=$team['sources']['espn']['pos_diff'];?></span></td>
							<td class="comments"><?=$team['comments'];?></td>
						</tr>
				<?php
						$cur_pos_avg = $team['average_w'];
						$i++;
					endforeach;
				?>
			</tbody>
		</table>


	<pre style="display:none;"><?php print_r($streaks->content); ?></pre>

	</div>

	<br /><br /><br />

</body>
</html>