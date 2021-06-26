<x-adminify-modal id="modalFileManager" modalClasses="" modalBodyClass="p-0"  modalDialogClasses="modal-xl" title="Titre" btnSave="" btnClear="">
    <div class="embed-responsive embed-responsive-16by9">
        @php
            $a = [];
            $routeName = request()->route()->getName();

            if($routeName == 'medias.create' || $routeName == 'medias.update') {
                $a['fromMediaCreate'] = true;
            }
        @endphp
        <iframe class="embed-responsive-item" src="{{ route('unisharp.lfm.show', $a ) }}"></iframe>
    </div>
</x-adminify-modal>
