import '../../dependencies/css/components/card.scss'

function CardSkeleton() {
    return (
        <div className="card skeleton">
            <div className="img"></div>
            <h2></h2>
            <p></p>
            <span className="price"></span>
            <div className="custom-card-select"></div>
        </div>
    )
}

export default CardSkeleton