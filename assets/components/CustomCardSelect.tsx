import { useState } from 'react';
import '../dependencies/css/components/custom-card-select.scss'

interface Data {
    id: number,
    size: string,
    quantity: number,
    price: number
}

interface CustomCardSelectProps {
    defaultSelectText: string;
    data: Data[]
}

//const dropDown = import.meta.env.VITE_IMG_URL + '/dependencies/images/drop-down.svg';
const dropDown = 'http://localhost:3000/assets/dependencies/images/drop-down.svg';

function CustomCardSelect({defaultSelectText, data}: CustomCardSelectProps) {
    const [showList, setShowList] = useState<boolean>(false)

    const getQuantityLabel = (quantity: number): string => {
        if (quantity === 0) return 'Epuisé'
        else if (quantity === 1) return 'C\'est le dernier, dépêchez vous!'
        else if (quantity > 1 && quantity < 5) return `Vite plus que ${quantity} en stock!`

        return 'En stock'
    }

    const handleClick = () => {
        setShowList(!showList)
    }

    return (
        <div className="custom-card-select" onClick={handleClick}>
            <div className="select-text">
                {defaultSelectText}
                <img src={dropDown} alt="drop-down" />
            </div>
            {showList && (
                <div className="select-list">
                    <ul>
                        <span className="article-category-label">Taille :</span>
                        {data.map(option => {
                            return (
                                <li
                                    data-name={option.id}
                                    key={option.id}
                                >
                                    <span>{option.size}</span>
                                    <span>{getQuantityLabel(option.quantity)}</span>
                                    <span className="price">{option.price} &euro;</span>
                                </li>
                            )
                        })}
                    </ul>
                </div>
            )}
        </div>
    )
}

export default CustomCardSelect