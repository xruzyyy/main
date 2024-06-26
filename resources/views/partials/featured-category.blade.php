<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    

  .container {
    max-width: 1400px;
    margin: auto;

     
    .grid-cards {
      display: flex;
      justify-content: center;
      flex: 1;
      max-width: 1024px;
      margin: 1rem auto;
      
      @media (max-width: 922px) and (min-width: 601px) {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
      }
      @media (max-width: 600px) {
        flex-direction: column;
      }
      
      .card {
        position: relative;
        flex: 1;
        background: black;
        padding: 1rem 1rem 1.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        border-radius: 1rem;
        margin: 15px;
        transition: all ease 0.3s;
        overflow: hidden;
        animation: fadeInLeft 1.5s backwards;
        
        &:nth-child(2){
          animation-delay: 0.15s;
         min-height: 170px;
       }
        &:nth-child(3){
          animation-delay: 0.2s;
        }
        &:nth-child(4){
          animation-delay: 0.3s;
        }
        
        &:hover {
         transform: translateY(-6px);
         -webkit-transform: translateY(-6px);
        }
        
        img {
          
          aspect-ratio: 500 / 320;
          
          width: 100%;
          border-radius: 12px;
          margin-bottom: 15px;
          position: relative;
          max-height: 320px;
          object-fit: cover;
          box-shadow: 0 6px 16px -7px #aaa;
        }
        
        .card-body {
          color: #676767;
          width: 100%;
          margin-bottom: 40px;
          padding: 0 0.8rem;
          position: relative;
          
          .icon {
            display: flex;
            width: 100%;
            text-align: left;
            padding: 15px 0;
            
            i {
              position: relative;
              font-size: 25px;
              transition: 0.5s;
              line-height: 0;
              top: -7px;
              left: -12px;
              z-index: 2;
              
              &::before {
                background-clip: border-box;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
              }
            }
            
            h3 {
              margin: -9px 0 0 20px;
            }
          }
          
          .title-card {
            text-align: center;
            padding-bottom: 10px;
          }
          
          p {
            font-size: 14px;
            line-height: 22px;
            font-weight: 300;
          }
        }
        
        .card-footer {
          display: flex;
          justify-content: flex-end;
          position: absolute;
          bottom: 0;
          width: calc(100% - 1rem);
          
          a {
            display: flex;
            justify-content: center;
            align-items: center;
            background: #FFD854;
            color: #fff;
            text-shadow: 0px 1px 5px rgba(0,0,0,0.08);
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            width: 56%;
            height: 40px;
            border-top-left-radius: 1rem;
            border-bottom-right-radius: 1rem;
            
            &:hover {
              filter: brightness(0.98);
            }
          }
        }
      }
    }
  }
  
  @keyframes fadeInLeft {
    0% {
      transform: translate(-100%,0);
    }
  
    100% {
        opacity: 1;
        transform: none;
    }
  }
  
  </style>
</head>
<body>
<div class="scroll">
<div class="container one">
  <h3 style="padding-left: 25px">LATEST LISTING</h3>
  <div class="grid-cards">
    <div class="card">
      <img src="https://images.unsplash.com/photo-1507206130118-b5907f817163?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&ixid=MnwxfDB8MXxyYW5kb218fHx8fHx8fHwxNjIzMzQzMjIz&ixlib=rb-1.2.1&q=80&w=600" alt="img-1" title="card image">
      <div class="card-body">
        <h3 class="title-card">
          Lorem ipsum dolor sit amet
        </h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam in vulputate dui. Curabitur orci augue, finibus vel imperdiet eu, posuere ac eros.
        </p>
      </div>
      <div class="card-footer">
        <a href="#">Click here</a>
      </div>
    </div>
    <div class="card">
      <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&ixid=MnwxfDB8MXxyYW5kb218fHx8fHx8fHwxNjIzMzQzNjkw&ixlib=rb-1.2.1&q=80&w=600" alt="img-2" title="card image">
      <div class="card-body">
        <h3 class="title-card">
          Lorem ipsum dolor
        </h3>
        <p>Suspendisse et commodo velit. Suspendisse porttitor, nisi ac luctus suscipit, risus dolor facilisis ligula
        </p>
      </div>
      <div class="card-footer">
        <a href="#">Click here</a>
      </div>
    </div>
    <div class="card">
      <img src="https://images.unsplash.com/photo-1538688273852-e29027c0c176?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&ixid=MnwxfDB8MXxyYW5kb218fHx8fHx8fHwxNjIzMzQzNjEx&ixlib=rb-1.2.1&q=80&w=600" alt="img-3" title="card image">
      <div class="card-body">
        <h3 class="title-card">
          Lorem ipsum dolor
        </h3>
        <p>Cras maximus eros eleifend luctus interdum. Vestibulum tincidunt nisi eget turpis faucibus, sit amet ultrices tortor tempor.
        </p>
      </div>
      <div class="card-footer">
        <a href="#">Click here</a>
      </div>
    </div>
  </div>
</div>
  
<div class="container one">
  <div class="grid-cards">
    <div class="card">
      <img src="https://images.unsplash.com/photo-1507206130118-b5907f817163?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&ixid=MnwxfDB8MXxyYW5kb218fHx8fHx8fHwxNjIzMzQzMjIz&ixlib=rb-1.2.1&q=80&w=600" alt="img-1" title="card image">
      <div class="card-body">
        <h3 class="title-card">
          Lorem ipsum dolor sit amet
        </h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam in vulputate dui. Curabitur orci augue, finibus vel imperdiet eu, posuere ac eros.
        </p>
      </div>
      <div class="card-footer">
        <a href="#">Click here</a>
      </div>
    </div>
    <div class="card">
      <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&ixid=MnwxfDB8MXxyYW5kb218fHx8fHx8fHwxNjIzMzQzNjkw&ixlib=rb-1.2.1&q=80&w=600" alt="img-2" title="card image">
      <div class="card-body">
        <h3 class="title-card">
          Lorem ipsum dolor
        </h3>
        <p>Suspendisse et commodo velit. Suspendisse porttitor, nisi ac luctus suscipit, risus dolor facilisis ligula
        </p>
      </div>
      <div class="card-footer">
        <a href="#">Click here</a>
      </div>
    </div>
    <div class="card">
      <img src="https://images.unsplash.com/photo-1538688273852-e29027c0c176?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&ixid=MnwxfDB8MXxyYW5kb218fHx8fHx8fHwxNjIzMzQzNjEx&ixlib=rb-1.2.1&q=80&w=600" alt="img-3" title="card image">
      <div class="card-body">
        <h3 class="title-card">
          Lorem ipsum dolor
        </h3>
        <p>Cras maximus eros eleifend luctus interdum. Vestibulum tincidunt nisi eget turpis faucibus, sit amet ultrices tortor tempor.
        </p>
      </div>
      <div class="card-footer">
        <a href="#">Click here</a>
      </div>
    </div>
  </div>
</div>

<div class="container one">
  <div class="grid-cards">
    <div class="card">
      <img src="https://images.unsplash.com/photo-1507206130118-b5907f817163?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&ixid=MnwxfDB8MXxyYW5kb218fHx8fHx8fHwxNjIzMzQzMjIz&ixlib=rb-1.2.1&q=80&w=600" alt="img-1" title="card image">
      <div class="card-body">
        <h3 class="title-card">
          Lorem ipsum dolor sit amet
        </h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam in vulputate dui. Curabitur orci augue, finibus vel imperdiet eu, posuere ac eros.
        </p>
      </div>
      <div class="card-footer">
        <a href="#">Click here</a>
      </div>
    </div>
    <div class="card">
      <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&ixid=MnwxfDB8MXxyYW5kb218fHx8fHx8fHwxNjIzMzQzNjkw&ixlib=rb-1.2.1&q=80&w=600" alt="img-2" title="card image">
      <div class="card-body">
        <h3 class="title-card">
          Lorem ipsum dolor
        </h3>
        <p>Suspendisse et commodo velit. Suspendisse porttitor, nisi ac luctus suscipit, risus dolor facilisis ligula
        </p>
      </div>
      <div class="card-footer">
        <a href="#">Click here</a>
      </div>
    </div>
    <div class="card">
      <img src="https://images.unsplash.com/photo-1538688273852-e29027c0c176?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=400&ixid=MnwxfDB8MXxyYW5kb218fHx8fHx8fHwxNjIzMzQzNjEx&ixlib=rb-1.2.1&q=80&w=600" alt="img-3" title="card image">
      <div class="card-body">
        <h3 class="title-card">
          Lorem ipsum dolor
        </h3>
        <p>Cras maximus eros eleifend luctus interdum. Vestibulum tincidunt nisi eget turpis faucibus, sit amet ultrices tortor tempor.
        </p>
      </div>
      <div class="card-footer">
        <a href="#">Click here</a>
      </div>
    </div>
  </div>
</div>
<script src="../scripts/script.js"></script>
</body>
</html>