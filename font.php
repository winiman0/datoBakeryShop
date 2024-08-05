<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <style>

    @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        
    .montserrat-alternates-thin {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 100;
        font-style: normal;
        }

        .montserrat-alternates-extralight {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 200;
        font-style: normal;
        }

        .montserrat-alternates-light {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 300;
        font-style: normal;
        }

        .montserrat-alternates-regular {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 400;
        font-style: normal;
        }

        .montserrat-alternates-medium {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 500;
        font-style: normal;
        }

        .montserrat-alternates-semibold {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 600;
        font-style: normal;
        }

        .montserrat-alternates-bold {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 700;
        font-style: normal;
        }

        .montserrat-alternates-extrabold {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 800;
        font-style: normal;
        }

        .montserrat-alternates-black {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 900;
        font-style: normal;
        }

        .montserrat-alternates-thin-italic {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 100;
        font-style: italic;
        }

        .montserrat-alternates-extralight-italic {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 200;
        font-style: italic;
        }

        .montserrat-alternates-light-italic {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 300;
        font-style: italic;
        }

        .montserrat-alternates-regular-italic {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 400;
        font-style: italic;
        }

        .montserrat-alternates-medium-italic {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 500;
        font-style: italic;
        }

        .montserrat-alternates-semibold-italic {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 600;
        font-style: italic;
        }

        .montserrat-alternates-bold-italic {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 700;
        font-style: italic;
        }

        .montserrat-alternates-extrabold-italic {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 800;
        font-style: italic;
        }

        .montserrat-alternates-black-italic {
        font-family: "Montserrat Alternates", sans-serif;
        font-weight: 900;
        font-style: italic;
        }


        .josefin-sans-js {
        font-family: "Josefin Sans", sans-serif;
        font-optical-sizing: auto;
        font-weight: <500>;
        font-style: normal;
        }
        .montserrat-monty {
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
            font-weight: 700;
            font-style: normal;
        }

        .poppins-thin {
            font-family: "Poppins", sans-serif;
            font-weight: 100;
            font-style: normal;
            }

            .poppins-extralight {
            font-family: "Poppins", sans-serif;
            font-weight: 200;
            font-style: normal;
            }

            .poppins-light {
            font-family: "Poppins", sans-serif;
            font-weight: 300;
            font-style: normal;
            }

            .poppins-regular {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
            }

            .poppins-medium {
            font-family: "Poppins", sans-serif;
            font-weight: 500;
            font-style: normal;
            }

            .poppins-semibold {
            font-family: "Poppins", sans-serif;
            font-weight: 600;
            font-style: normal;
            }

            .poppins-bold {
            font-family: "Poppins", sans-serif;
            font-weight: 700;
            font-style: normal;
            }

            .poppins-extrabold {
            font-family: "Poppins", sans-serif;
            font-weight: 800;
            font-style: normal;
            }

            .poppins-black {
            font-family: "Poppins", sans-serif;
            font-weight: 900;
            font-style: normal;
            }

            .poppins-thin-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 100;
            font-style: italic;
            }

            .poppins-extralight-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 200;
            font-style: italic;
            }

            .poppins-light-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 300;
            font-style: italic;
            }

            .poppins-regular-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: italic;
            }

            .poppins-medium-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 500;
            font-style: italic;
            }

            .poppins-semibold-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 600;
            font-style: italic;
            }

            .poppins-bold-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 700;
            font-style: italic;
            }

            .poppins-extrabold-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 800;
            font-style: italic;
            }

            .poppins-black-italic {
            font-family: "Poppins", sans-serif;
            font-weight: 900;
            font-style: italic;
            }

    </style>
</head>
<body>
</body>
</html>