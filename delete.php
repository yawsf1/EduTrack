<li><button class="btn_delete_acc" id="btn_delete_acc"><span>Supprimer le compte</span><i class="fa-solid fa-user-xmark"></i></button></li>
<style>
  #everything{
    position: relative;
  }
  .btn_delete_acc{
      display: flex;
    align-items: center;
    justify-content: space-between;
    line-height: 50px;
    font-size: 16px;
    color: #C5C6C7;
    width: 100%;
    transition: color 0.4s;
    background-color: #1F2833;
    border: none;
        font-family: "Poppins", sans-serif;
  font-weight: 600;
  font-style: normal;
  transition: color 0.4s, background-color 0.4s;
  cursor: pointer;
    color: rgba(212, 15, 15, 1);
    text-shadow: 0.5px 0.5px 3px #0B0C10;

  }
  #header1:hover #ul1>li>.btn_delete_acc{
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 16px;
    color: rgba(212, 15, 15, 1);
    width: 100%;
  }
  #header1:hover #ul1>li>.btn_delete_acc>span{
    display:flex;
    align-items: center;
    justify-content: space-between;
}
#header1:hover #ul1>li>.btn_delete_acc>i{
    padding-left: 10px;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}
#header1>#ul1>li:hover .btn_delete_acc{
    color: rgba(212, 15, 15, 1);
    background-color: #0B0C10;
}


.delete_notif{
  display: none;
  align-items: center;
  justify-content: space-between;
  padding: 20px;
  width: 500px;
  height: 300px;
  background-color: #1F2833;
  position: absolute;
  top: 50%;
  left: 50%;
  translate: -50% -50%;
  border-radius: 12px;
  flex-wrap: wrap;
  z-index: 40000;
}
.delete_notif_title {
  color: #C5C6C7;
  font-size: 1.4rem;
  text-align: center;
  flex-grow: 1;
  flex-basis: 400px;
}
.delete_notif_button_accept{
  width: 120px;
  height: 40px;
  background-color: rgba(212, 15, 15, 1);
  color: #0B0C10;
        font-family: "Poppins", sans-serif;
  font-weight: 600;
  font-style: normal;
  border-radius: 6px;
  font-size: 1rem;
      border: none;
    cursor: pointer;
}
.delete_notif_button_cancel{
  width: 120px;
  height: 40px;
  background-color: #C5C6C7;
  color: #1F2833;
  font-family: "Poppins", sans-serif;
  font-weight: 600;
  font-style: normal;
    border-radius: 6px;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;

}
.delete_notif_buttons_container{
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
  background-color: #1F2833;
  height: auto;
}
#cancel_delete_container{
  height: 40px;
  width: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #45A29E;
  color: #1F2833;
  position: absolute;
  top: 10px;
  right: 10px;
  margin: 0;
  padding: 0;
  cursor: pointer;
}
</style>
