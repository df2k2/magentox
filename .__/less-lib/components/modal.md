# Modal popups
`.lib-modal-popup()`

```html
<div class="modals-wrapper">
<aside
    class="modal-popup _show"
    data-role="modal"
    data-type="popup">
    <div class="modal-inner-wrap">
         <header class="modal-header">
             <h1 class="modal-title" data-role="title">Modal Popup</h1>
             <button
                 class="action-close"
                 data-role="closeBtn"
                 type="button">
                 <span>Close</span>
             </button>
         </header>
         <div class="modal-content" data-role="content">
             Modal Content
         </div>
         <footer class="modal-content" data-role="content">
             Modal Footer
         </footer>
    </div>
</aside>
<div class="modals-overlay"></div>
</div>
```



# Modal slide panels
`.lib-modal-slide()`

```html
<div class="modals-wrapper">
    <aside
        class="modal-slide _show"
        data-role="modal"
        data-type="slide">
        <div class="modal-inner-wrap">
                <header class="modal-header">
                    <h1 class="modal-title" data-role="title">Modal Slide</h1>
                    <button
                        class="action-close"
                        data-role="closeBtn"
                        type="button">
                        <span>Close</span>
                    </button>
                </header>
                <div class="modal-content" data-role="content">
                    Modal Content
                </div>
                <footer class="modal-content" data-role="content">
                    Modal Footer
                </footer>
        </div>
    </aside>
    <div class="modals-overlay"></div>
</div>
```