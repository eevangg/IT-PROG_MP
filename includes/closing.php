        <!-- confirmation toast -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="toast" class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
            <div class="toast-body" id="toastBody"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
        </div>

        <!-- delete toast -->
        <div aria-live="polite" aria-atomic="true" class="position-fixed top-50 start-50 translate-middle" style="z-index: 11">
            <div id="deleteToast" class="toast background-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <div id="deleteToastAlert"></div>
                    <form id="deleteForm" method="post">
                        <div id="delete_message"></div>
                        <div class="mt-2 pt-2 border-top">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="toast">Close</button>
                            <button id="deleteToastBtn" type="submit" class="btn btn-danger btn-sm float-end">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
   </div>
</body>
</html>