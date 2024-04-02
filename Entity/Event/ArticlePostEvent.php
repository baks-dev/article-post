<?php
/*
 *  Copyright 2023.  Baks.dev <admin@baks.dev>
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is furnished
 *  to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in all
 *  copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

declare(strict_types=1);

namespace BaksDev\Article\Post\Entity\Event;

use BaksDev\Article\Post\Entity\ArticlePost;
use BaksDev\Article\Post\Entity\Modify\ArticlePostModify;
use BaksDev\Article\Post\Type\Event\ArticlePostEventUid;
use BaksDev\Article\Post\Type\Id\ArticlePostUid;
use BaksDev\Core\Type\Locale\Locale;
use BaksDev\Core\Type\Modify\ModifyAction;
use BaksDev\Core\Type\Modify\ModifyActionEnum;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use BaksDev\Core\Entity\EntityEvent;
use BaksDev\Core\Entity\EntityState;
use InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;


/* ArticlePostEvent */

#[ORM\Entity]
#[ORM\Table(name: 'article_post_event')]
class ArticlePostEvent extends EntityEvent
{
    public const TABLE = 'article_post_event';

    /**
     * Идентификатор События
     */
    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[ORM\Id]
    #[ORM\Column(type: ArticlePostEventUid::TYPE)]
    private ArticlePostEventUid $id;

    /**
     * Идентификатор ArticlePost
     */
    #[Assert\NotBlank]
    #[Assert\Uuid]
    #[ORM\Column(type: ArticlePostUid::TYPE, nullable: false)]
    private ?ArticlePostUid $main = null;


    /**
     * Модификатор
     */
    #[ORM\OneToOne(targetEntity: ArticlePostModify::class, mappedBy: 'event', cascade: ['all'])]
    private ArticlePostModify $modify;

    public function __construct()
    {
        $this->id = new ArticlePostEventUid();
        $this->modify = new ArticlePostModify($this);

    }

    /**
     * Идентификатор События
     */

    public function __clone()
    {
        $this->id = new ArticlePostEventUid();
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function getId(): ArticlePostEventUid
    {
        return $this->id;
    }

    /**
     * Идентификатор ArticlePost
     */
    public function setMain(ArticlePostUid|ArticlePost $main): void
    {
        $this->main = $main instanceof ArticlePost ? $main->getId() : $main;
    }


    public function getMain(): ?ArticlePostUid
    {
        return $this->main;
    }

    public function getDto($dto): mixed
    {
        if($dto instanceof ArticlePostEventInterface)
        {
            return parent::getDto($dto);
        }

        throw new InvalidArgumentException(sprintf('Class %s interface error', $dto::class));
    }

    public function setEntity($dto): mixed
    {
        if($dto instanceof ArticlePostEventInterface)
        {
            return parent::setEntity($dto);
        }

        throw new InvalidArgumentException(sprintf('Class %s interface error', $dto::class));
    }


    //	public function isModifyActionEquals(ModifyActionEnum $action) : bool
    //	{
    //		return $this->modify->equals($action);
    //	}

    //	public function getUploadClass() : ArticlePostImage
    //	{
    //		return $this->image ?: $this->image = new ArticlePostImage($this);
    //	}

    //	public function getNameByLocale(Locale $locale) : ?string
    //	{
    //		$name = null;
    //		
    //		/** @var ArticlePostTrans $trans */
    //		foreach($this->translate as $trans)
    //		{
    //			if($name = $trans->name($locale))
    //			{
    //				break;
    //			}
    //		}
    //		
    //		return $name;
    //	}
}