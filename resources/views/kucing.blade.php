<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Naga Realistis</title>
  <style>
    body {
      margin: 0;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(#0d0d0d, #1a1a1a);
      overflow: hidden;
    }
    .dragon {
      position: relative;
      width: 350px; /* Lebar lebih besar untuk proporsi yang lebih baik */
      height: 200px;
      animation: fly 4s ease-in-out infinite;
    }

    /* Tubuh naga dengan gradien dan bayangan untuk volume */
    .body {
      position: absolute;
      width: 300px;
      height: 120px;
      background: radial-gradient(circle at 50% 50%, #1b5e20 0%, #0d3310 100%);
      border-radius: 50% / 60%;
      box-shadow: inset 0 0 40px rgba(0,0,0,0.8), 
                  0 0 30px rgba(0,255,0,0.2);
    }

    /* Ekor yang lebih lancip dan bervolume */
    .tail {
      position: absolute;
      right: -80px;
      top: 50px;
      width: 150px;
      height: 50px;
      background: linear-gradient(90deg, #1b5e20 0%, #0d3310 100%);
      border-radius: 40% 60% 60% 40% / 50%;
      transform-origin: left center;
      animation: wag 2s ease-in-out infinite;
      box-shadow: inset 0 0 15px rgba(0,0,0,0.6);
    }
    .tail::after {
      content: "";
      position: absolute;
      right: -30px;
      top: 8px;
      border-left: 35px solid #1b5e20;
      border-top: 20px solid transparent;
      border-bottom: 20px solid transparent;
      filter: drop-shadow(2px 2px 5px rgba(0,0,0,0.5));
    }

    /* Kepala yang lebih berlekuk dan ekspresif */
    .head {
      position: absolute;
      left: -90px;
      top: 20px;
      width: 100px;
      height: 80px;
      background: #0d3310;
      border-radius: 40% 60% 60% 40% / 50%;
      box-shadow: 0 0 30px rgba(0,255,0,0.5);
      animation: headmove 3s ease-in-out infinite;
    }

    /* Tanduk yang lebih tajam */
    .horn {
      position: absolute;
      top: -25px;
      width: 0; height: 0;
      border-left: 18px solid transparent;
      border-right: 18px solid transparent;
      border-bottom: 30px solid #4caf50;
      filter: drop-shadow(0 0 8px #0f0);
    }
    .horn.left { left: 12px; transform: rotate(-25deg); }
    .horn.right { right: 12px; transform: rotate(25deg); }

    /* Mata yang lebih menyala */
    .eye {
      position: absolute;
      top: 30px;
      width: 18px;
      height: 18px;
      background: #f00;
      border-radius: 50%;
      box-shadow: 0 0 15px 5px #f00, 0 0 25px 8px #ff3333;
      animation: glow 1s alternate infinite;
    }
    .eye.left { left: 20px; }
    .eye.right { right: 20px; }

    /* Sayap yang lebih beralur dengan clip-path */
    .wing {
      position: absolute;
      top: -100px;
      left: 60px;
      width: 180px;
      height: 150px;
      background: #2e7d32;
      opacity: 0.9;
      transform-origin: bottom center;
      animation: flap 2s ease-in-out infinite;
      filter: drop-shadow(0 0 20px rgba(0,255,0,0.4));
      /* Menggunakan clip-path untuk bentuk sayap yang lebih kompleks */
      clip-path: polygon(10% 0, 90% 0, 100% 50%, 90% 100%, 50% 90%, 0% 100%, 10% 50%);
    }

    /* Animasi yang sedikit disesuaikan */
    @keyframes wag {
      0%, 100% { transform: rotate(15deg); }
      50% { transform: rotate(-25deg); }
    }
    @keyframes flap {
      0%, 100% { transform: rotate(-15deg) scaleY(1.1); }
      50% { transform: rotate(20deg) scaleY(1); }
    }
    @keyframes glow {
      from { box-shadow: 0 0 6px 3px #f00, 0 0 10px 4px #ff3333; }
      to   { box-shadow: 0 0 25px 8px #ff3333, 0 0 40px 10px #f00; }
    }
    @keyframes headmove {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
    @keyframes fly {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-15px); }
    }
  </style>
</head>
<body>
  <div class="dragon">
    <div class="body"></div>
    <div class="tail"></div>
    <div class="head">
      <div class="horn left"></div>
      <div class="horn right"></div>
      <div class="eye left"></div>
      <div class="eye right"></div>
    </div>
    <div class="wing"></div>
  </div>
</body>
</html>