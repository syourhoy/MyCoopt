// Load the Visualization API and the piechart package.
          google.load('visualization', '1.0', {'packages':['corechart']});

          // Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawChart);
          // Callback that creates and populates a data table,
          // instantiates the pie chart, passes in the data and
          // draws it.
function test() {
    setTimeout(function drawChart() {
   
            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');    
            data.addColumn('number', 'Slices');
            data.addRows([
              ['CV OK', 10],
              ['CV NOK', 10],
              ['EC1', 10],
              ['EC2', 10],
              ['EP', 10],
              ['ED', 10],
              ['Embauche',10],
              ['Entrée', 10],
              ['Validation de la période d\'essai', 10]
            ]);
            // Create the data table.
            var data2 = new google.visualization.DataTable();
            data2.addColumn('string', 'Topping');
            data2.addColumn('number', 'Slices');
            data2.addRows([
              ['SI', 10],
              ['TELCO', 10],
              ['WEB', 10],
              ['INDUS', 10],
              ['BFA', 10],
              ['SUPPORT', 10]
            ]);

            var data3 = new google.visualization.DataTable();
            data3.addColumn('string', 'Topping');
            data3.addColumn('number', 'Slices');
            data3.addRows([
              ['CGA', 10],
              ['BCH', 10],
              ['BRF', 10],
              ['RHA', 10],
              ['NPC', 10],
              ['BXL', 10],
              ['PACA', 10],
              ['SUISSE', 10],
              ['INTERNE',10]
            ]);

            // Set chart options
              var options = {'title':'Par status',
			     "width":600,
			     "height":400};
            // Set chart options
              var options2 = {'title':'Par métier',
			      "width":600,
			      "height":400};
            // Set chart options
              var options3 = {'title':'Par agence',
			      "width":600,
			      "height":400};

     // Instantiate and draw our chart, passing in some options.
     
            var chart = new google.visualization.PieChart(document.getElementById("chart_div"));
            chart.draw(data, options);
            var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
            chart2.draw(data2, options2);
             var chart3 = new google.visualization.PieChart(document.getElementById('chart_div3'));
         chart3.draw(data3, options3);
          
    }, 1000);
   
}
