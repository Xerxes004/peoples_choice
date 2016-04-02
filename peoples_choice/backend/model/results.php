<?php

class ResultsPage extends Model
{
	public function getResultsData($proj)
	{
		$names = $this->getNames($proj);
		$first = "['13','14','10']";
		$second = "['9','11','10']";
		$third = "['3','9','10']";

		$jsonData = 
			"{
			  	labels: $names,
			  	series: [$first, $second, $third]
			}, {
				seriesBarDistance: 5,
			  	stackBars: true,
			  	horizontalBars: true,
			  	onlyInteger: true,
			  	axisY: {
			  		offset: 150
			  	},
			  	axisX: {
      				labelInterpolationFnc: function (value, index) {
      					return index % 5 === 0 ? value : null;
      				}
    			},
			}).on('draw', function(data) {
			  	if(data.type === 'bar') {
			    	data.element.attr({
			      		style: 'stroke-width: 20px'
				    });
				  }
			}";

		return $jsonData;
	}

	private function getNames($proj)
	{
		return "['Wes','Joel','Andrew']";
	}
}
?>
