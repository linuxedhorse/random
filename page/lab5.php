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
                <li class="menuitem"><a href="lab1.php">Равномерное распределение</a></li>
                <li class="menuitem"><a href="lab2.php">Распределение Симпсона</a></li>
                <li class="menuitem"><a href="lab3.php">Нормальное распределение</a></li>
                <li class="menuitem"><a href="lab4.php">Экспоненциальное распределение</a></li>
                <li class="menuitem"><a href="lab5.php" class="active">Распределение Эрланга</a></li>
            </ul>
        </div>
        <!-- Содержимое страницы -->
        <div class="content">
            <h2>Лабораторная работа</h2>
            <br/>
<div class="gg">
    <h3>Числа</h3> <input type="text" id="num" value=""><br/>
    <h3>Интервалы</h3> <input type="text" id="int" value=""><br/>
    <h3>Смещение</h3> <input type="text" id="x" value=""><br/><br/>
<input id="but" type="button" value="Построить график">
</div>

<div class="graph">
	<div class="ct-chart ct-perfect-fourth"></div>
</div>
<script>
function sortNumber(a, b){
	return a - b;
}
function getRand(min, max){
	return Math.random() * (max - min) + min;
}
function getMasRand(len, min, max){
	var mas = [];
			for (var i = 0; i < len; i++){
				mas[i] = Math.random() * (max - min) + min;
				//console.log(mas[i]);
			};
			mas.sort(sortNumber);
			//console.log(mas);
			return mas;
}
function integral(colElem, interval){
	var a = 0, b = 1, n = 100, s = 0, d = (b - a)/n, xb = 0, xe = 0, xm = 0, G = 0;

	for(i = 0; i < n; i++){
		xe = xb + d;
		xm = (xb + xe)/2;
		s = s + d*xm*xm;
		xb = xe;
	}
	G = s;
	return G;
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
	if(isNumeric(document.getElementById('num').value) && isNumeric(document.getElementById('int').value)){

	var mas = [], vhod = [], ver = [], Sver = [], intervalS = [], series = [], ticks = [];
	var colElem = 1000, interval = 50, count = 0, box = 0, 
	a = 7,	Mx = 0.5, k = 2, la = 5;

	colElem = Math.abs(document.getElementById('num').value);
	interval = Math.abs(document.getElementById('int').value);
	//D = Math.abs(document.getElementById('d').value);
	//x = Math.abs(document.getElementById('x').value);
	
	mas = getMasRand(colElem,  0, 1);
	min = mas[0];
	max = mas[colElem-1];
	//console.log('max-> ' + max);
	//console.log('min-> ' + min);
	step = (max - min) / interval; 
	//console.log('step-> ' + step);
	intervalS[0] = min;
	var i = 1
	while (box < max){
		box = intervalS[i-1] + step;
		intervalS[i] = box;
		i++;
	}//for (var i = 0; i < intervalS.length; i++) {
	//	console.log('min-> ' + intervalS[i] + ' max-> ' + intervalS[i+1]);
	//};

box = 0;
var m = 0;
for (var i = 0; i < intervalS.length; i++) {
	ver[i] = (Math.pow(a, k)/integral(k))*Math.pow(intervalS[i], k-1) * Math.pow(2.71828182846, -a * intervalS[i]);
	console.log(ver[i]);
};

/*
	box = 0;
	var m = 0;
	for (var i = 0; i < intervalS.length; i++) {
		E = 0;
		var verN = masVer(colElem, interval);
		//console.log(verN);
		for (var m = box; m < n; m++) {
			E += verN[m];
			//console.log('E ['+i+'] -> ' + E);
		};
		ver[i] = (Mx + Qx * Math.sqrt(12/n) * (E - n/2));
		console.log(ver[i]);
	};
*/

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

	//ticks = unique(ticks);
	//console.log(series);
	//console.log(ticks);

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
		alert('Введите число !');
	}

	//var elapsed = new Date().getTime() - start; // рассчитаем время выполнения
	//console.log(elapsed);
}
		//lineSmooth: Chartist.Interpolation.cardinal({
    	//	tension: 0.1
  		//}),
</script>
    </div>
    </div>
</body>
</html>