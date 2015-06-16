<!DOCTYPE html>
<html lang="en">
<head>
    <script type="text/javascript" src="scripts/demos.js"></script>
    <title id='Description'>jqxChart Greyscale Rendering Example</title>
    <link rel="stylesheet" href="jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxchart.core.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            
            // prepare chart data as an array
            var sampleData = [
			<?php
				if(isset($_POST['submit']))
				{
					$ct=array();
					
					foreach(range('A','Z') as $c)
					{
						$ct[$c]=0;
					}
					if(isset($_FILES['inp']))
					{
						$file = fopen($_FILES['inp']['tmp_name'],"r");
						while (! feof ($file))
						{
							$cd=fgetc($file);
							if(ctype_alpha($cd))
							{
								$cdU=strtoupper($cd);
								$z=$ct[$cdU];
								$ct[$cdU]=$z+1;
							}
						}
					}
					
					$c=1;
					foreach (range('A','Z') as $ch)
					{
						if($c == 1)
							echo "{ Day: '$ch', Top: ". ($ct[$ch]/3) .", Middle: ". ($ct[$ch]/3) .", Bottom: ". ($ct[$ch]/3) ." }";
						else
							echo ",{ Day: '$ch', Top: ". ($ct[$ch]/3) .", Middle: ". ($ct[$ch]/3) .", Bottom: ". ($ct[$ch]/3) ." }";
						
						$c=$c+1;
						
					}
				}
			else
			{
				
				$c=1;
				foreach (range('A','Z') as $ch)
				{
					if($c == 1)
						echo "{ Day: '$ch', Top: 0, Middle: 0, Bottom: 0 }";
					else
						echo ",{ Day: '$ch', Top: 0, Middle: 0, Bottom: 0 }";
                    
					$c=$c+1;
					
				}
			}
				
					?>
                ];

            // prepare jqxChart settings
            var settings = {
                title: "Fitness & exercise weekly scorecard",
                description: "Time spent in vigorous exercise by activity",
                enableAnimations: true,
                showLegend: true,
                padding: { left: 5, top: 5, right: 5, bottom: 5 },
                titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                source: sampleData,
                xAxis:
                    {
                        dataField: 'Day',
                        showTickMarks: true,
                        tickMarksInterval: 1,
                        tickMarksColor: '#888888',
                        unitInterval: 1,
                        showGridLines: false,
                        gridLinesInterval: 1,
                        gridLinesColor: '#888888',
                        axisSize: 'auto'
                    },
                colorScheme: 'scheme05',
                seriesGroups:
                    [
                        {
                            type: 'splinearea',
                            valueAxis:
                            {
                                unitInterval: 5,
                                minValue: 0,
                                maxValue: 500,
                                displayValueAxis: false,
                                description: 'Goal in minutes',
                                axisSize: 'auto',
                                tickMarksColor: '#888888'
                            },
                            series: [
                                    { greyScale: true, dataField: 'Goal', displayText: 'Personal Goal', opacity: 0.7 }
                                ]
                        },
                        {
                            type: 'stackedcolumn',
                            columnsGapPercent: 100,
                            seriesGapPercent: 5,
                            valueAxis:
                            {
                                unitInterval: 30,
                                minValue: 0,
                                maxValue: 1000,
                                displayValueAxis: true,
                                description: 'Time in minutes',
                                axisSize: 'auto',
                                tickMarksColor: '#888888',
                                gridLinesColor: '#777777'
                            },
                            series: [
                                    { greyScale: false, dataField: 'Top', displayText: 'Top' },
                                    { greyScale: false, dataField: 'Middle', displayText: 'Middle' },
                                    { greyScale: false, dataField: 'Bottom', displayText: 'Bottom' }
                                ]
                        }
                    ]
            };

            // setup the chart
            $('#chartContainer').jqxChart(settings);
            $("#Running").jqxCheckBox({ width: 120,  checked: true });
            $("#Swimming").jqxCheckBox({ width: 120,  checked: true });
            $("#Cycling").jqxCheckBox({ width: 120,  checked: true });
            $("#Goal").jqxCheckBox({ width: 120,  checked: false });
            var groups = $('#chartContainer').jqxChart('seriesGroups');
            var refreshChart = function () {
                $('#chartContainer').jqxChart({ enableAnimations: false });
                $('#chartContainer').jqxChart('refresh');
            }
            // update greyScale values.
            $("#Running").on('change', function (event) {
                groups[1].series[0].greyScale = !event.args.checked;
                refreshChart();
            });
            $("#Cycling").on('change', function (event) {
                groups[1].series[2].greyScale = !event.args.checked;
                refreshChart();
            });
            $("#Swimming").on('change', function (event) {
                groups[1].series[1].greyScale = !event.args.checked;
                refreshChart();
            });
            $("#Goal").on('change', function (event) {
                groups[0].series[0].greyScale = !event.args.checked;
                refreshChart();
            });
        });
    </script>
</head>
<body class='default'>

	<div style='padding:3%;' >
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" >
		Select the file :<input type='file' name='inp' />
		<input type='submit' name='submit' value='submit' />
	</form>
	</div>
    <div id='chartContainer' style="width: 850px; height: 500px">
    </div>
	
	<!--
    <div style='margin-top: 10px;'>
        <div style='float: left;'>
            <div id='Running'>Running</div>
            <div style='margin-top: 5px;' id='Swimming'>Swimming</div>
        </div>
        <div style='float: left;'>
            <div id='Cycling'>Cycling</div>
            <div style='margin-top: 5px;' id='Goal'>Personal Goal</div>
        </div>
    </div>
	-->
</body>
</html>
