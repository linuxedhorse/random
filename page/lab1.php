<?php
	include "url.php";
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style.css" />
<link rel="stylesheet" type="text/css" href="../c.min.css" />
<script src="../c.min.js"></script>
<title>Лабораторная</title>
</head>

<body>
<div id="container">
        <div id="header">
            <a href="../index.html"><h1>Random</h1></a>
        </div>
       <!-- Верхнее меню -->
        <div id="menu">
            <ul>
                <li class="menuitem"><a href="lab1.php" class="active">Равномерное распределение</a></li>
                <li class="menuitem"><a href="lab2.php">Распределение Симпсона</a></li>
                <li class="menuitem"><a href="lab3.php">Нормальное распределение</a></li>
                <li class="menuitem"><a href="lab4.php">Экспоненциальное распределение</a></li>
                <li class="menuitem"><a href="lab5.php">Распределение Эрланга</a></li>
            </ul>
        </div>
        <!-- Содержимое страницы -->
        <div class="content">
            <h2>Лабораторная работа</h2>
            <br/>
                <h3>Числа</h3><input type="text" id="num" value="">
                <h3>Интервалы</h3><input type="text" id="int" value=""><br/><br/>
                <h3>Диапазон</h3><br/>
                <span style="color: #33729B"><b>A</b> </span><input type="text" id="a" value="" size="6px">
	            <span style="color: #33729B"><b>B</b> </span><input type="text" id="b" value="" size="5px">
                <br/>
                <br/>
                <div class="xx">
                    <h3>Метод</h3><br/>
	                <input type="radio" name="metod" value="1" checked="true"> Случайный<br/>
            	    <input type="radio" name="metod" value="2"> Простые конгруэнции<br/>
            	    <input type="radio" name="metod" value="3"> Линейные конгруэнции<br/>
                </div>
                <br/>
	            <input id="but" type="button" value="Построить график">
               <div class="graph">
	<div class="ct-chart ct-perfect-fourth"></div>
    <script>
function sortNumber(a, b){
	return a - b;
}
function getMasRand(len, metod, min, max){
	var mas = [], arr = [];
	switch(metod){
		case 1:
			for (var i = 0; i < len; i++){
				mas[i] = Math.random() * (max - min) + min;
			};
			mas.sort(sortNumber);
			return mas;
		case 2:
		var A, p = Math.pow(10, 64);
		 A = 20000;
		 mas[0] = Math.random() * (max - min) + min;
			for (var i = 0; i < len; i++){
				mas[i+1] = (A * mas[i]) % p;
				console.log(mas[i]);
			};
			mas.sort(sortNumber);
			return mas;
		case 3:
		var a = c = mas[0] = 2, m = 1000;
			for (var i = 0; i < len - 1; i++){
				mas[i+1] = ((a * mas[i] + c) % m);
			};
			mas.sort(sortNumber);
			console.log(mas);
			return mas;

	}
}
function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
function unique(arr) {
  var result = [];

  nextInput:
    for (var i = 0; i < arr.length; i++) {
      var str = arr[i]; 
      for (var j = 0; j < result.length; j++) { 
        if (result[j] == str) continue nextInput; 
      }
      result.push(str);
    }
  return result;
}


document.getElementById('but').onclick = function() {
	//var start = new Date().getTime();
	if(isNumeric(document.getElementById('num').value) && isNumeric(document.getElementById('int').value)
		&& isNumeric(document.getElementById('a').value) && isNumeric(document.getElementById('b').value)){

	var mas = [], vhod = [], ver = [], intervalS = [];
	var colElem = 1000, interval = 20, count = 0, box = 0, metod = 0, a = 0, b = 1, series = [], ticks = [];

	colElem = Math.abs(document.getElementById('num').value);
	interval = Math.abs(document.getElementById('int').value);
	a = Math.abs(document.getElementById('a').value);
	b = Math.abs(document.getElementById('b').value);
	metod = +document.querySelector('input[name="metod"]:checked').value;
	mas = getMasRand(colElem, metod, a, b);
	min = mas[0];
	max = mas[colElem-1];
	//console.log('max-> ' + max);
	//console.log('min-> ' + min);
	step = (max - min) / interval ; 
	//console.log('step-> ' + step);
	intervalS[0] = min;
	var i = 1
	while (box <= max){
		box = intervalS[i-1] + step;
		intervalS[i] = box;
		i++;
	} 
	box = 0;
	var m = 0;
	for (var i = 0; i < intervalS.length; i++) {
		count = 0;
		for (m = box; m < mas.length; m++) {
			if(mas[m] >= intervalS[i] && mas[m] <= intervalS[i+1]){
				count++;
			}else{
				box = m;
				break;
			}
		};
		vhod[i] = count;
		ver[i] = +(count/mas.length).toFixed(3);
	};
	console.log(mas);
	box = 0
	if(interval <= 20){
		box = 2;
	}else{
		box = 1;
	}

	for (var i = 0; i < ver.length; i++) {
		series.push(ver[i]);
		ticks.push(+intervalS[i].toFixed(box));
	};

	var data = {
	  labels: ticks,
	  series: [
	    series
	  ]
	};

	var options = {
	  seriesBarDistance: 10
	};

	var responsiveOptions = [
	  ['screen and (max-width: 640px)', {
	    seriesBarDistance: 5,
	    axisX: {
	      labelInterpolationFnc: function (value) {
	        return value[0];
	      }
	    }
	  }]
	];

	new Chartist.Bar('.ct-chart', data, options, responsiveOptions);

	}else{
		alert('Должно быть введено число');
	}

}
</script>
            
</div>
       </div>
</div>
</body>
</html>