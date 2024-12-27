export interface Cart{
  cid: string
  products: Array<Product>
}

export interface Product {id: number, qty: number}

export interface DisplayCart {
  id: number
  productName: string
  productBrand: string
  price: number
  category: string
  image: string
  sku: string
  status: string
  qty: number
  inStock: boolean
}


export interface Person {
  id: number
  name: string
  email: string
  contact: string
}

export interface EmittedValue {
  id?:number
  key: "name" | "contact" | "email"
  value: string | number
}
