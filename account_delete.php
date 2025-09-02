<form action="<?=$path;?>.php" method="POST" class="delete_notif" id="delete_notif">
    <h1 class="delete_notif_title">Êtes-vous sûr de vouloir supprimer votre compte ?</h1>
    <div class="delete_notif_buttons_container">
        <button name="delete_account" class="delete_notif_button_accept" type="submit">Supprimer</button>
        <div class="delete_notif_button_cancel">Annuler</div>
    </div>
    <div ><i id='cancel_delete_container' class='fa-solid fa-xmark'></i></div>
</form>