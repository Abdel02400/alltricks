import { useState, useEffect } from 'react';
import '../dependencies/css/components/custom-card-select.scss'

interface Data {
    id: number,
    size: string,
    quantity: number,
    price: number
}

interface CustomCardSelectProps {
    defaultSelectText: string,
    selectLabel: string,
    data: Data[]
}

//const dropDown = import.meta.env.VITE_IMG_URL + '/dependencies/images/drop-down.svg';
const dropDown = 'http://localhost:3000/assets/dependencies/images/drop-down.svg';

function CustomCardSelect({defaultSelectText, selectLabel, data}: CustomCardSelectProps) {
    const [showList, setShowList] = useState<boolean>(false)
    const [selectText, setSelectText] = useState<string>(defaultSelectText)

    const getQuantityLabel = (quantity: number): string => {
        if (quantity === 0) return 'Epuisé'
        else if (quantity === 1) return 'C\'est le dernier, dépêchez vous!'
        else if (quantity > 1 && quantity < 5) return `Vite plus que ${quantity} en stock!`

        return 'En stock'
    }

    const handleClickShowList = () => {
        setShowList(!showList)
    }

    const handleClick = (e) => {
        console.log(e.target)
        setSelectText(e.target.getAttribute("data-value"))
    }

    return (
        <div className="custom-card-select" onClick={handleClickShowList}>
            <div className="select-text">
                {selectText}
                <img src={dropDown} alt="drop-down" />
            </div>
            {showList && (
                <div className="select-list">
                    <ul>
                        <span className="article-category-label">{selectLabel} :</span>
                        {data.map(option => {
                            return (
                                <li
                                    className="select-option"
                                    data-name={option.id}
                                    data-value={option.size}
                                    key={option.id}
                                    onClick={e => handleClick(e)}
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