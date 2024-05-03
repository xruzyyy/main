<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>services</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&display=swap");

@mixin mQ($rem) {
  @media screen and (min-width: $rem) {
    @content;
  }
}
p{
    color: #000000;
}
h2 {
  font-family: "Playfair Display", serif;
  font-optical-sizing: auto;
  font-weight: 400;
  font-style: normal;
}

.cardServices {
  position: relative;

  &::before {
    position: absolute;
    content: "";
    width: 100%;
    height: 100%;
    transition: 0.6s;
    z-index: 0;
    background-color: #0e151866;
  }

  &:hover {
    box-shadow: 0.063rem 0.063rem 1.25rem 0.375rem rgb(0 0 0 / 53%);
  }

  &:nth-child(1)::before {
    bottom: 0;
    right: 0;
    clip-path: circle(calc(6.25rem + 7.5vw) at 100% 100%);
  }

  &:nth-child(2)::before {
    bottom: 0;
    left: 0;
    clip-path: circle(calc(6.25rem + 7.5vw) at 0% 100%);
  }

  &:nth-child(3)::before {
    top: 0;
    right: 0;
    clip-path: circle(calc(6.25rem + 7.5vw) at 100% 0%);
  }

  &:nth-child(4)::before {
    top: 0;
    left: 0;
    clip-path: circle(calc(6.25rem + 7.5vw) at 0% 0%);
  }

  p {
    color: #000000;
    transition: 0.8s;
  }
}

.cardServices:hover::before {
  clip-path: circle(110vw at 100% 100%);
}

.cardServices:hover p {
  color: #000000;
}

.circle {
  (62.5rem) {
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 0;
  }
}

.cardServices:nth-child(1) .circle {
  background: url("https://images.unsplash.com/photo-1587440871875-191322ee64b0?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D")
    no-repeat 50% 50% / cover;
  bottom: 0;
  right: 0;
  clip-path: circle(calc(6.25rem + 7.5vw) at 100% 100%);
}

.cardServices:nth-child(2) .circle {
  background: url("https://images.unsplash.com/photo-1499951360447-b19be8fe80f5?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D")
    no-repeat 50% 50% / cover;
  bottom: 0;
  left: 0;
  clip-path: circle(calc(6.25rem + 7.5vw) at 0% 100%);
}
.cardServices:nth-child(3) .circle {
  background: url("https://images.unsplash.com/photo-1557804506-669a67965ba0?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D")
    no-repeat 50% 50% / cover;
  top: 0;
  right: 0;
  clip-path: circle(calc(6.25rem + 7.5vw) at 100% 0%);
}

.cardServices:nth-child(4) .circle {
  background: url("https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D")
    no-repeat 50% 50% / cover;
  top: 0;
  left: 0;
  clip-path: circle(calc(6.25rem + 7.5vw) at 0% 0%);
}

    </style>
</head>
<body>
    <section class="min-h-screen bg-gray-900 text-center py-20 px-8 xl:px-0 flex flex-col justify-center">

        <h1 class="text-black text-4xl md:text-5xl xl:text-6xl font-semibold max-w-3xl mx-auto mb-16 leading-snug">Services Offered by Taytay Businesses</h1>
        <div class="grid-offer text-left grid sm:grid-cols-2 md:grid-cols-2 gap-5 max-w-5xl mx-auto">
          <div class="cardServices bg-gray-800 p-10 relative">
            <div class="circle">
            </div>
            <div class="relative lg:pr-52">
              <h2 class="capitalize text-black mb-4 text-2xl xl:text-3xl">Custom Apparel <br /> Manufacturing</h2>
              <p class="text-gray-400">Creating custom-designed clothing and apparel for various occasions, from casual wear to uniforms and corporate attire.</p>
            </div>
            <div class="icon"></div>
          </div>
          <div class="cardServices bg-gray-800 p-10 relative">
            <div class="circle">
            </div>
            <div class="relative lg:pl-48">
              <h2 class="capitalize text-black mb-4 text-2xl xl:text-3xl">Garment <br /> Retail</h2>
              <p class="text-gray-400">Selling a wide range of ready-to-wear garments, including dresses, shirts, pants, and accessories, catering to different styles and preferences.</p>
            </div>
          </div>
          <div class="cardServices bg-gray-800 p-10 relative">
            <div class="circle">
            </div>
            <div class="relative lg:pr-44">
              <h2 class="capitalize text-black mb-4 text-2xl xl:text-3xl">Tailoring <br /> Services</h2>
              <p class="text-gray-400">Providing expert tailoring and alteration services to ensure that garments fit perfectly and meet customers' specific requirements.</p>
            </div>
          </div>
          <div class="cardServices bg-gray-800 p-10 relative">
            <div class="circle">
            </div>
            <div class="relative lg:pl-48">
             <h2 class="capitalize text-black mb-4 text-2xl xl:text-3xl">Fashion <br /> Consultation</h2>
      <p class="text-gray-400">Providing personalized fashion consultation services to individuals and businesses, offering expert advice on style, trends, and wardrobe planning.</p>

            </div>
          </div>
        </div>
      </section>

</body>
</html>
