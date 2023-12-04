<?php

/*
*  Copyright Baks.dev <admin@baks.dev>
*
*  Licensed under the Apache License, Version 2.0 (the "License");
*  you may not use this file except in compliance with the License.
*  You may obtain a copy of the License at
*
*  http://www.apache.org/licenses/LICENSE-2.0
*
*  Unless required by applicable law or agreed to in writing, software
*  distributed under the License is distributed on an "AS IS" BASIS,
*  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
*  See the License for the specific language governing permissions and
*   limitations under the License.
*
*/

namespace BaksDev\Article\Post\Entity;

use BaksDev\Article\Post\Type\Event\ArticlePostEventUid;
use BaksDev\Article\Post\Type\Id\ArticlePostUid;
use BaksDev\Products\Product\Type\Event\ProductEventUid;
use BaksDev\Products\Product\Type\Id\ProductUid;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/* Product */


#[ORM\Entity]
#[ORM\Table(name: 'article_post')]
class ArticlePost //extends Event
{
	
	public const TABLE = 'product';
	
	/** ID */
    #[Assert\NotBlank]
    #[Assert\Uuid]
	#[ORM\Id]
	#[ORM\Column(type: ArticlePostUid::TYPE)]
	private ArticlePostUid $id;
	
	/** ID События */
    #[Assert\NotBlank]
    #[Assert\Uuid]
	#[ORM\Column(type: ArticlePostEventUid::TYPE, unique: true)]
	private ArticlePostEventUid $event;
	
	
	public function __construct() { $this->id = new ArticlePostUid(); }
	
	
	public function getId() : ArticlePostUid
	{
		return $this->id;
	}

	
	public function getEvent() : ArticlePostEventUid
	{
		return $this->event;
	}
	
	
	public function setEvent(ProductEventUid|Event\ArticlePostEvent $event) : void
	{
		$this->event = $event instanceof Event\ArticlePostEvent ? $event->getId() : $event;
	}
	
}