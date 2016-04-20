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
        <div class="gg">
	<input id="but" type="button" value="Смоделировать систему">
	<div class="rig">
		Кол-во потребителей <input type="text" id="r" value="">
		Кол-во товаров <input type="text" id="m" value="">
		Кол-во дней <input type="text" id="G" value="">
	</div>
</div>


<div class="graph">
	<span class='h' id='h'>Процент удовлетворенности потребителей по каждому товару</span>
	<div class="ct-chart ct-perfect-fourth" id="chart1"></div>
</div>

<div class="info">
	<span id='H'></span><br><br>
	<span id='L'></span><br><br>

</div> 

<div class="graph">
	<span class='h' id='hh'>Количество товара на начало и конец дня</span>
	<div class="ct-chart ct-perfect-fourth" id="chart2"></div>
</div>
<script>

function getMasRand(min, max){
	return Math.round(Math.random() * (max - min) + min);
}
function arrayPad(ar, size, value) {
	var len = Math.abs(size) - ar.length;
	var a = [].concat(ar);
	if (len <= 0)
		return a;
	for(var i = 0; i < len; i++)
		size < 0 ? a.unshift(value) : a.push(value);
	return a;
}
document.getElementById('but').onclick = function() {
	document.getElementById('h').style.display = 'inline-block';
	document.getElementById('hh').style.display = 'inline-block';
	var m = 10, r = 2, G = 30;
	var b = arrayPad([], r, 10000), //15000
	l = arrayPad([], r, 8500), //8000
	C = [], a = [], R = arrayPad([], r, 6350), //6200
	A = 0, A1 = 0, S = 0, D = arrayPad([], r, 0), F = arrayPad([], r, 0),
	K = arrayPad([], r, 0), day = [], GlobC = [], GlobB = [], H = 0, L = 0
	proc = [], glob = [];

	while(S <= G){

		for (var i = 0; i < r; i++){
			a[i] = [];
			a[i][m] = 0;
			for (var j = 0; j < m; j++) {
				a[i][j] = getMasRand(500, 800);
				a[i][m] += a[i][j];
			};
		};

		for (var i = 0; i < r; i++) {
		};
		
		for (var i = 0; i < r; i++) {
			A += a[i][m];
		};

		for (var i = 0; i < r; i++) {
			F[i] += F[i] + a[i][m];
		};
		glob[S] = [];
		var countC = 0;
		for (var i = 0; i < r; i++) {
			C[i] = b[i] - a[i][m];
			countC += C[i];
		};
		GlobC.push(Math.round(countC/r));
		var countB = 0;
		for (var i = 0; i < r; i++) {
			if(C[i]<0){
				glob[S][i] = (100 - ((C[i]/b[i])*100));
				proc.push(100 - ((C[i]/a[i][m])*100));
				b[i] = R[i];
				D[i] = D[i] + C[i];
			}else if(C[i]<l[i]){
				glob[S][i] = (100 - ((C[i]/b[i])*100));
				proc.push(100 - ((C[i]/b[i])*100)); 
				b[i] = C[i] + R[i];
			}else{
				glob[S][i] = (100 - ((C[i]/b[i])*100));
				proc.push(100 - ((C[i]/b[i])*100));
				b[i] = C[i];
			}
			countB += b[i];

		};

		GlobB.push(Math.round(countB/r));

		day.push(S);
		A1 = A1 + A;
		S++;

	}
	//console.log('A1 => ' + A1);
	//console.log('S => ' + S);

	for (var i = 0; i < r; i++) {
		K[i] = D[i]/F[i];
	};
	//console.log('K => ' + K);

	for (var i = 0; i < r; i++) {
		H += D[i];
	};

	L = H/A1;

	document.getElementById('H').innerHTML = 'Общее количество неудовлетворенных заявок: ' + H;
	document.getElementById('L').innerHTML = 'Доля невыполненных заявок к общему числу заявок: ' + L.toFixed(4);
	
	var kkk = [], maxDay = [], maxR = [], l = 0;
	for (var i = 0; i < r; i++) {
	var lll = [];
		for (var S = 0; S < G; S++) {
			lll.push(glob[S][i]);
			if(glob[S][i] >= 95){
				maxR[l] = glob[S][i];
				maxDay[l] = S;
				l++;
			}
		};
		kkk.push(lll);
	};

console.log(maxDay);
console.log(maxR);

	var chart = new Chartist.Line('#chart1', {
  labels: day,
  series: kkk
}, {
  fullWidth: true,
  chartPadding: {
    right: 10
  },
  lineSmooth: Chartist.Interpolation.cardinal({
    fillHoles: true,
  }),
  low: 0
},{
  seriesBarDistance: 10,
  axisX: {
    offset: 60
  },
  axisY: {
    offset: 80,
    labelInterpolationFnc: function(value) {
      return value + ' %'
    },
    scaleMinSpace: 15
  }
});

	var data = {
	  labels: day,
	  series: [
	  		GlobB,
	  		GlobC
	  		]	  
	};

	var options = {
	  showPoint: true,
	  lineSmooth: false,
	  axisX: {
	    showGrid: false,
	    showLabel: true
	  },
	  axisY: {
	    offset: 60,
	    labelInterpolationFnc: function(value) {
	      return value;
	    }
	  }
	};

	new Chartist.Line('#chart2', data, options);

}
		
</script>


    </div>
</body>
</html>