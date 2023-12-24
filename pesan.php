<div class="modal fade" id="pesanModal<?= $i ?>" tabindex="-1" role="dialog"
                            aria-labelledby="pesanModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="pesanModalLabel">Form Pemesanan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="kontainer-judul">
                                            <h1>Order Tiket Pesawat</h1>
                                        </div>
                                        <div class="kont-order">
                                    <form action="pilkur.php" method="post">
                                        </div>
                                        <input type="hidden" name="id_jadwal" id="id_jadwal" value="<?= $info['No'] ?>">
                                        <div>
                                            <label for="name">Nama:</label>
                                            <input type="text" name="namaPembeli" id="namaPembeli" required>
                                        </div>
                                        <div>
                                            <label for="email">Email:</label>
                                            <input type="email" name="emailPembeli" id="emailPembeli" required>
                                        </div>
                                        <input type="submit" value="Next" name="order" class="tombol">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>