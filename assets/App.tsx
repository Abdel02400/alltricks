import { useState, useEffect } from 'react'
import Card from './components/Card'
import CardSkeleton from './components/skeleton/CardSkeleton'

import './dependencies/css/app.scss'

function App() {
  const [onLoadArticle, setOnLoadArticle] = useState<boolean>(true)
  const [articles, setArticles] = useState({})

  const loadArticle = async () => {
    let requestOptions = {method: 'GET'}
    let response = await fetch('http://localhost:8000/api/articles')

    if (response.status === 200) {
      let articles = await response.json()
      setArticles(articles)
      setOnLoadArticle(false)
    }
  }
  
  const renderCardSkeleton = () => {

    let cardSkeleton = []

    for (let i = 0; i < 6; i++) {
      cardSkeleton.push(<CardSkeleton key={i}/>)
    }

    return cardSkeleton
  }

  const renderCard = () => {
    let card = []
    
    if (Object.keys(articles).length > 0) {
      Object.entries(articles).forEach(([key, value]) => {
        card.push(<Card article={value} key={key} />)
    });
    }
  
    return card
  }

  useEffect(() => {
    loadArticle()
  }, [])

  return (
    <div className="articles container">
      {onLoadArticle ? renderCardSkeleton() : renderCard()}
    </div>
  )
}

export default App
