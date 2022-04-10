import { useState } from 'react'

import CustomCardSelect from './CustomCardSelect';

import '../dependencies/css/components/card.scss'

//const chaussure = import.meta.env.VITE_IMG_URL + '/dependencies/images/chaussure.png';
const chaussure = 'http://localhost:3000/assets/dependencies/images/chaussure.jpg';

function Card() {

    const [defaultSelectText, setDefaultSelectText] = useState('VEUILLEZ SÉLECTIONNER')

    const [data, setData] = useState([
      { id: 1, size: "S", quantity: 5, price: 12.99 },
      { id: 2, size: "S", quantity: 0, price: 12.99 },
      { id: 3, size: "S", quantity: 5, price: 12.99 },
      { id: 4, size: "S", quantity: 3, price: 12.99 },
      { id: 5, size: "S", quantity: 5, price: 12.99 },
      { id: 6, size: "S", quantity: 5, price: 12.99 },
      { id: 7, size: "S", quantity: 1, price: 12.99 },
      { id: 8, size: "S", quantity: 5, price: 12.99 },
      { id: 9, size: "S", quantity: 5, price: 12.99 },
      { id: 10, size: "S", quantity: 5, price: 12.99 }
    ])

    return (
        <div className="card">
            <img className="img" src={chaussure} alt="image de l'article" />
            <h2>title de l'image</h2>
            <p>contenu de l'image</p>
            <span className="price">120 &euro;</span>
            <CustomCardSelect defaultSelectText={defaultSelectText} data={data} />
            {/* <select className="select" name="product-size">
                <option>VEUILLEZ SÉLECTIONNER</option>
                <option value="10" data-stock="2" data-price="18.00 €">S</option>
                <option value="11" data-stock="5" data-price="18.00 €">M</option>
                <option value="12" data-stock="0" data-price="18.00 €">L</option>
                <option value="13" data-stock="2" data-price="22.00 €">XL</option>
            </select> */}
        </div>
    )
}

export default Card