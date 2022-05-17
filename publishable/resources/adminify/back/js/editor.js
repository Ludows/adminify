import * as VisualEditorPackage from '@boxraiser/visual-editor/VisualEditor.standalone'

console.log(VisualEditorPackage);

let ObjectKeys = Object.keys(VisualEditorPackage)
ObjectKeys.filter((key) => {
    return !['VisualEditor', 'VisualEditorComponent', 'React'].includes(key);
})

window.Editor = new VisualEditorPackage.VisualEditor();
//register Namespace components
window.Editor.components = {};
ObjectKeys.forEach((Key) => {
    window.Editor.components[Key] = VisualEditorPackage[Key];
})

// window.Editor = new VisualEditor();
