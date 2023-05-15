<?php
  use Cursotopia\Helpers\Format;
?>
<?php foreach ($this->chats as $chat) : ?>
  <div class="chat-drawer p-2 border-bottom" data-id="<?= $chat["id"] ?>">
    <a href="#" class="text-decoration-none d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="chat-section" aria-expanded="false" aria-controls="collapseExample">
      <div class="d-flex flex-row flex-nowrap align-items-center overflow-hidden">
        <img 
          src="api/v1/images/<?= $chat["profilePicture"] ?>" 
          alt="avatar" 
          width="60"
          height="60"
          class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
        >
        <div class="overflow-hidden text-nowrap">
          <p class="h5 fw-bold mb-0">
            <?= $chat["user"] ?>
          </p>
          <small class="text-primary mb-0 <?= $chat["unseenMessagesCount"] !== 0 ? 'fw-bold' : '' ?>">
            <?= $chat["lastMessageContent"] ?>
          </small>
        </div>
      </div>
      <div>
        <p class="small text-muted mb-1 text-end">
          <?= Format::datetime($chat["lastMessageCreatedAt"]) ?>
        </p>
        <?php if ($chat["unseenMessagesCount"] !== 0) : ?>
          <span class="badge rounded-pill bg-danger float-end">
            <?= $chat["unseenMessagesCount"] ?>
          </span>
        <?php else : ?>
          <span style="visibility: hidden">s</span>
        <?php endif ?>
      </div>
    </a>
  </div>
<?php endforeach ?>