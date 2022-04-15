import { useState, useEffect } from 'react'

import CustomCardSelect from './CustomCardSelect';

import '../dependencies/css/components/card.scss'

function Card({article}) {

    const [defaultSelectText, setDefaultSelectText] = useState('VEUILLEZ SÉLECTIONNER')

    const [data, setData] = useState(article.stocks)

    return (
        <div className="card">
            <img className="img" src={article.img_src} alt="image de l'article" />
            <h2>{article.name}</h2>
            <p>{article.content}</p>
            <span className="price">{article.stocks[0].price} &euro;</span>
            <CustomCardSelect defaultSelectText={defaultSelectText} data={data} />
        </div>
    )
}

export default Card