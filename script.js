document.addEventListener('DOMContentLoaded', () => {

    console.log('Plataforma Coser Clau Dias carregada com sucesso!');

    let produtos = [];

    const catalogGrid =
        document.querySelector('.catalog-grid');

    //carrinho

    let cart = JSON.parse(
        localStorage.getItem('coser_cart')
    ) || [];

    updateCartCount();
    // produtos 

    fetch('api_produtos.php')

        .then(response => {

            if (!response.ok) {

                throw new Error(
                    'Erro ao carregar produtos'
                );

            }

            return response.json();

        })

        .then(data => {

            produtos = data;

            if (catalogGrid) {

                renderProducts(produtos);

            }

        })

        .catch(error => {

            console.error('Erro:', error);

        });
    // imagens e produtos

    function renderProducts(items) {

        catalogGrid.innerHTML = '';

        items.forEach(prod => {

            const card =
                document.createElement('div');

            card.className = 'product-card';

            card.innerHTML = `

            <div class="product-img">

                <img
                    src="${prod.imagem}"
                    alt="${prod.nome}"
                    style="
                        width:100%;
                        height:250px;
                        object-fit:cover;
                        border-radius:10px;
                        cursor:pointer;
                    "
                >

            </div>

            <div class="product-info">

                <span>${prod.categoria}</span>

                <h3>${prod.nome}</h3>

                <p class="product-price">

                    R$ ${parseFloat(prod.preco)
                        .toFixed(2)
                        .replace('.', ',')}

                </p>

                <div class="personalization"
                     style="margin-bottom:1rem;">

                    <label
                        style="
                        font-size:0.8rem;
                        display:block;
                        margin-bottom:5px;
                        ">

                        Nome do Bebê:

                    </label>

                    <input
                        type="text"
                        placeholder="Ex: Julia"
                        class="baby-name"

                        style="
                        width:100%;
                        padding:8px;
                        border:1px solid #ddd;
                        border-radius:8px;
                        ">

                </div>

                <button
                    class="btn add-to-cart"
                    data-id="${prod.id}"

                    style="
                    padding:0.7rem 1rem;
                    font-size:0.9rem;
                    border:none;
                    cursor:pointer;
                    width:100%;
                    ">

                    Adicionar ao Carrinho

                </button>

            </div>

            `;

            //abrir imagem 
            const imagem =
                card.querySelector('.product-img');

            imagem.addEventListener(
                'click',
                function(e){

                    e.stopPropagation();

                    abrirImagem(prod.imagem);

                }
            );

            catalogGrid.appendChild(card);

        });
     //entrar no carrinho
        document.querySelectorAll('.add-to-cart')

            .forEach(button => {

                button.addEventListener('click', (e) => {

                    const productId = parseInt(

                        e.target.getAttribute('data-id')

                    );

                    const product = produtos.find(

                        p => parseInt(p.id) === productId

                    );

                    const babyName =

                        e.target
                            .parentElement
                            .querySelector('.baby-name')
                            .value;

                    addToCart(product, babyName);

                });

            });

    }

    
    //colocaar no carrinho

    function addToCart(product, babyName) {

        const item = {

            id: product.id,

            nome: product.nome,

            preco: product.preco,

            categoria: product.categoria,

            babyName: babyName || 'Não informado',

            cartId: Date.now()

        };

        cart.push(item);

        localStorage.setItem(

            'coser_cart',

            JSON.stringify(cart)

        );

        updateCartCount();

        // Abrir checkout 
        window.location.href = 'checkout.html';

    }
    function updateCartCount() {

        const cartCount =
            document.getElementById('cart-count');

        if (cartCount) {

            cartCount.innerText = cart.length;

        }

    }
    //finaliza 

    const cartBtn =
        document.getElementById('cart-btn');

    if (cartBtn) {

        cartBtn.addEventListener('click', (e) => {

            e.preventDefault();

            window.location.href =
                'checkout.html';

        });

    }
    // rola 
    document.querySelectorAll('a[href^="#"]')

        .forEach(anchor => {

            anchor.addEventListener(
                'click',

                function (e) {

                    e.preventDefault();

                    const target =
                        document.querySelector(

                            this.getAttribute('href')

                        );

                    if (target) {

                        target.scrollIntoView({

                            behavior: 'smooth'

                        });

                    }

                }

            );

        });

});

// botao p carregar

window.addEventListener('load', () => {

    const loader =
        document.getElementById('loader');

    if (loader) {

        loader.style.opacity = '0';

        loader.style.transition =
            '0.3s ease';

        setTimeout(() => {

            loader.remove();

        }, 300);

    }

});

function abrirImagem(imagem) {

    const popup =
        document.createElement('div');

    popup.style.position = 'fixed';
    popup.style.top = '0';
    popup.style.left = '0';
    popup.style.width = '100%';
    popup.style.height = '100%';
    popup.style.background = 'rgba(0,0,0,0.8)';
    popup.style.display = 'flex';
    popup.style.justifyContent = 'center';
    popup.style.alignItems = 'center';
    popup.style.zIndex = '9999';

    popup.innerHTML = `
    
        <img
            src="${imagem}"
            style="
                max-width:80%;
                max-height:80%;
                border-radius:15px;
                box-shadow:0 0 20px #000;
            "
        >
    
    `;

    popup.onclick = function () {

        popup.remove();

    };

    document.body.appendChild(popup);

}
