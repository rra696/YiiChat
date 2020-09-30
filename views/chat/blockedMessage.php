<ul class="list-unstyled">
    <?php foreach($messages as $message) : ?>
        <li id="blocked_message_<?=$message->getId()?>">
            <?=$message->getText()?>
            <button class="btn btn-default btn-sm" title="Разблокировать сообщение" onclick="unblockMessage(<?=$message->getId()?>)">
                <i class="fa fa-unlock" aria-hidden="true"></i>
            </button>
            
        </li>
        
    <?php endforeach ?>              
</ul>


