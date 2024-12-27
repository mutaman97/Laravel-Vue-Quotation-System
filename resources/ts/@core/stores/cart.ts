import { defineStore } from "pinia";
import { v4 as uuid4 } from 'uuid';
import { Cart, DisplayCart, Product } from './interfaces';


interface State{
  cart: Cart | {},
  displayCart: DisplayCart[] | []
}

interface Products {
  id: number
  productName: string
  productBrand: string
  price: number
  category: string
  image: string
  sku: string
  status: string
  qty: number
  stock: number
  inStock: boolean
}


const { data: productsData, execute: fetchProducts } = await useApi<any>(createUrl('/apps/ecommerce/products'))

const products: Products[] = productsData.value.products
console.log(products)

const totalProduct = computed(() => productsData.value.total)

export const useCartStore = defineStore('cart',{
    state: ()=>({cart: {}, displayCart: []} as State),
    actions:{
        loadCartInstance()
        {
            const cs = localStorage.getItem('cart')
            if(!cs)
            this.cart = {}
            else
            this.cart = JSON.parse(cs)
        },
        addToCart(product: Product){
            const cs = localStorage.getItem('cart')

            let isAdded = false

            if(!cs)
            this.cart = {
                cid: uuid4(),
                products:[
                    product
                ]
            }
            else {
                let cartLocalStorage = JSON.parse(cs)
                cartLocalStorage.products = cartLocalStorage.products.map((ci : Product) => {
                    if(ci.id == product.id)
                    {
                        isAdded = true
                        return {id: ci.id, qty: ci.qty + 1}
                    }

                    return {id: ci.id, qty: ci.qty}
                })

                if(!isAdded)
                cartLocalStorage.products.push({id: product.id, qty: product.qty})

                this.cart = cartLocalStorage
               

            }

            localStorage.setItem('cart', JSON.stringify(this.cart))

        },
        
        removeFromCart(id:number){
                (this.cart as Cart).products = (this.cart as Cart).products.filter(ci => ci.id != id) 
                this.displayCartLoad()
                localStorage.setItem('cart', JSON.stringify(this.cart))
        },


        displayCartLoad(){
            this.displayCart = (this.cart as Cart).products.map(ci => {
              const requiredProduct = products.filter(p => p.id == ci.id)[0];
              // if(requiredProduct[0].stock >= ci.qty)


                if (!requiredProduct) {
                  console.error(`Product with ID ${ci.id} not found in the products array.`);
                  return {
                      id: ci.id,
                      productName: "Unknown Product",
                      productBrand: "Unknown Brand",
                      price: 0,
                      category: "Unknown Category",
                      image: "default-image.jpg",
                      sku: "N/A",
                      status: "Unavailable",
                      qty: ci.qty,
                      inStock: false,
                  };
              }

                return {
                    id:ci.id,
                    productName: requiredProduct.productName,
                    productBrand: requiredProduct.productBrand,
                    price: requiredProduct.price,
                    category: requiredProduct.category,
                    image: requiredProduct.image,
                    sku: requiredProduct.sku,
                    status: requiredProduct.status,
                    qty: ci.qty,
                    inStock: requiredProduct.stock >= ci.qty ? true : false }
            })

        }

    }
})
