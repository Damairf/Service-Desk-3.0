<template>
    <div class="container">
      <div class="greet">
      <h1>Selamat datang, "Nama User"</h1>
      <p>
        Ada yang bisa kami bantu?
      </p>
    </div>
    <div class="boxHolder">
      <div class="box">
        <h3>Permintaan Baru</h3>
        <p>Mulai permintaan pelayanan pada Diskominfo Jabar</p>
        <button class="tambah">Baru</button>
      </div>
      <div class="box">
        <h3>Lacak Permintaan</h3>
        <p>Mulai permintaan pelayanan pada Diskominfo Jabar</p>
        <button class="lacak">Lacak</button>
      </div>
    </div>
    </div>
  </template>
  
  <style>
    html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  </style>
  
  <style scoped>
  
  .container{
    background-color: #FAF4FF;
    min-height: 100vh;
  }
  
  .greet h1{
    color: black;
    margin: 0;
    margin-top: 2rem;
    font-size: 37px;
  }
  
  .greet p{
    color: #6B6B6B;
    margin-top: 1rem;
    font-size: 20px;
  }
  
  .boxHolder{
    display: flex;
    justify-content: center;
  }
  
  .box{
    background-color: white;
    width: 20rem; 
    height: 20rem;
    border-radius: 8px;
    box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
  
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    margin-top: 5rem;
    margin-left: 2.5rem;
  }
  
  .box h3 {
    text-align: left;
    margin: 0;
  }
  .box p {
    margin: 0 1rem; /* supaya gak mepet kiri-kanan */
    color: #333;
    font-size: 0.9rem;
    text-align: left;
    font-weight: lighter;
  }
  
  /*tombol baru & lacak*/
  .tambah, .lacak {
    background-color: #006920;
    border-radius: 100px;
    color: white;
    cursor: pointer;
    margin-top: 1.2rem;
  
    /*text*/
    font-size: 1.25rem;
    font-weight: bold;
    padding: 1rem 3rem;
    border: none;
    min-width: 100px; 
  }
  
  </style>