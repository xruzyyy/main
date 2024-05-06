<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Services</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .containerService {
            height: 120vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .services-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .services-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .services-header p {
            font-size: 16px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }

        .service-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .service-title {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
        }

        .service-icon {
            font-size: 36px;
            margin-bottom: 15px;
            color: #ff6b6b;
        }

        .service-description {
            font-size: 14px;
            color: #666;
        }

        @media (max-width: 768px) {
            .containerService {
                height: auto;
                padding: 10px;
            }

            .services-header h1 {
                font-size: 28px;
            }

            .services-header p {
                font-size: 14px;
            }

            .service-card {
                padding: 15px;
            }

            .service-title {
                font-size: 18px;
            }

            .service-icon {
                font-size: 32px;
                margin-bottom: 10px;
            }

            .service-description {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="containerService">
        <div class="services-header">
            <h1>Services Offered by Taytay Businesses</h1>
            <p>Explore our range of services tailored just for you.</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-tshirt"></i>
                </div>
                <div class="service-title">Custom Apparel Manufacturing</div>
                <div class="service-description">Creating custom-designed clothing and apparel for various occasions, from casual wear to uniforms and corporate attire.</div>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="service-title">Garment Retail</div>
                <div class="service-description">Selling a wide range of ready-to-wear garments, including dresses, shirts, pants, and accessories, catering to different styles and preferences.</div>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-cut"></i>
                </div>
                <div class="service-title">Tailoring Services</div>
                <div class="service-description">Providing expert tailoring and alteration services to ensure that garments fit perfectly and meet customers' specific requirements.</div>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="service-title">Fashion Consultation</div>
                <div class="service-description">Providing personalized fashion consultation services to individuals and businesses, offering expert advice on style, trends, and wardrobe planning.</div>
            </div>
        </div>
    </div>
</body>

</html>
