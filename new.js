// This code lives in new.js - this is the CUSTOMER asking WAITER for food
document.addEventListener('DOMContentLoaded', () => {
  const grid = document.getElementById('productGrid');
  
  // Call the waiter (API)
  fetch('api/products.php')
    .then(res => res.json())
    .then(products => {
      grid.innerHTML = ''; // clear
      products.forEach(p => {
        const discountPrice = Math.round(p.price * 0.6);
        grid.innerHTML += `
          <article class="new-product-card">
            <div class="product-image-wrapper">
              <img src="${p.image}" class="product-image">
              <span class="badge badge-new">NEW</span>
            </div>
            <div class="product-info">
              <div class="size-row">
                <button class="size-btn">S</button><button class="size-btn">M</button><button class="size-btn">L</button><button class="size-btn">XL</button>
              </div>
              <div class="price-stack">
                <strong>Actual Price: Rs ${p.price}</strong>
                <h6>Launch discount 40%</h6>
                <span>After discount: Rs ${discountPrice}</span>
              </div>
              <button class="btn btn-primary btn-add" onclick="addToCart(${p.id})">Add to Cart</button>
            </div>
          </article>
        `;
      });
    })
    .catch(err => {
      console.log(err);
      grid.innerHTML = '<p>Failed to load products</p>';
    });
});

function addToCart(id){
  console.log('Add to cart', id);
}