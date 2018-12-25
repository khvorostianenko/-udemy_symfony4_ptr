<?php

namespace App\EventListener;

use App\Entity\LikeNotification;
use App\Entity\MicroPost;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\PersistentCollection;

# EventSubscriber из Doctrine\Common\EventSubscriber; работает со всеми событиями, которые происходят в Доктрине
class LikeNotificationSubscriber implements EventSubscriber
{
    /**
     * from EventSubscriber
     */
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush,
        ];
    }
    
    # Мы хотим отловить при onFlush что в Entity/MicroPost.php произошло добавление в коллекцию $this->likedBy->add($user);
    
    /**
     * Имя метода должно соответствавать значению константы Events::onFlush, то есть имя метода другое выбрать нельзя
     */
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        # Аналог транзации в Доктрине
        $uow = $em->getUnitOfWork();
    
        # список всех Collections которые были persisted, или объектов которые implements DoctrineCollectionInterface
        
        /** @var PersistentCollection $collectionUpdate */
        foreach ($uow->getScheduledCollectionUpdates() as $collectionUpdate) {
            if (!$collectionUpdate->getOwner() instanceof MicroPost) {
                continue;
            }
            
            if ($collectionUpdate->getMapping()['fieldName'] !== 'likedBy') {
                continue;
            }
            
            $insertDiff = $collectionUpdate->getInsertDiff();
            
            if (!count($insertDiff)) {
                return;
            }
            
            /** @var MicroPost $microPost */
            $microPost = $collectionUpdate->getOwner();
            
            $notification = new LikeNotification();
            $notification->setUser($microPost->getUser());
            $notification->setMicroPost($microPost);
            $notification->setLikedBy(reset($insertDiff));
            
            $em->persist($notification);
            
            # грубо говоря добавляем в общую транзацию
            $uow->computeChangeSet(
                $em->getClassMetadata(LikeNotification::class),
                $notification
            );
        }
    }
}