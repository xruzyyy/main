<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Services</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;1,400&display=swap");

        p {
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
            background-color: #ffffff !important;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .cardServices:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .circle {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-size: cover;
            filter: brightness(0.5);
        }

        .cardServices:hover .circle {
            background-image: url("https://images.unsplash.com/photo-1587440871875-191322ee64b0?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D");
            background-size: cover;
            background-position: center;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 1.5rem;
            justify-content: center;
            /* Center horizontally */
            justify-items: center;
            /* Center each card */
        }

        @media (max-width: 639px) {
            .cardServices {
                margin: 2em !important; /* Set margin for screens >= 640px */
            }
        }
        @media (min-width: 640px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
                margin: 2em;
            }
        }

        @media (min-width: 1024px) {
            .grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

    </style>
</head>

<body>
    <section class="min-h-screen text-center py-20 px-8 xl:px-0 flex flex-col justify-center">

        <h1 class="text-white text-4xl md:text-5xl xl:text-6xl font-semibold max-w-3xl mx-auto mb-16 leading-snug">
            Services Offered by Taytay Businesses</h1>

        <div class="grid-offer">
            <div class="grid">
                <div class="cardServices relative overflow-hidden">
                    <div class="circle"></div>
                    <div class="relative lg:pr-52">
                        <h2 class="capitalize text-black mb-4 text-2xl xl:text-3xl">Custom Apparel Manufacturing</h2>
                        <p class="text-gray-400">Creating custom-designed clothing and apparel for various occasions,
                            from casual wear to uniforms and corporate attire.</p>
                    </div>
                </div>
                <div class="cardServices relative overflow-hidden">
                    <div class="circle"></div>
                    <div class="relative lg:pl-48">
                        <h2 class="capitalize text-black mb-4 text-2xl xl:text-3xl">Garment Retail</h2>
                        <p class="text-gray-400">Selling a wide range of ready-to-wear garments, including dresses,
                            shirts, pants, and accessories, catering to different styles and preferences.</p>
                    </div>
                </div>
                <div class="cardServices relative overflow-hidden">
                    <div class="circle"></div>
                    <div class="relative lg:pr-44">
                        <h2 class="capitalize text-black mb-4 text-2xl xl:text-3xl">Tailoring Services</h2>
                        <p class="text-gray-400">Providing expert tailoring and alteration services to ensure that
                            garments fit perfectly and meet customers' specific requirements.</p>
                    </div>
                </div>
                <div class="cardServices relative overflow-hidden">
                    <div class="circle"></div>
                    <div class="relative lg:pl-48">
                        <h2 class="capitalize text-black mb-4 text-2xl xl:text-3xl">Fashion Consultation</h2>
                        <p class="text-gray-400">Providing personalized fashion consultation services to individuals and
                            businesses, offering expert advice on style, trends, and wardrobe planning.</p>
                    </div>
                </div>
            </div>
        </div>

    </section>

</body>

</html>
