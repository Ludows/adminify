import React, {useMemo, useEffect, useState} from 'react';
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import * as VisualEditorPackage from '@boxraiser/visual-editor/VisualEditor.standalone';

export default function VisualEditorElement(props) {
    const field = useMemo(() => props.field, []);
    const [hidden, setHidden] = useState(true);
    const register = useMemo(() => props.register, [props]);

    useEffect(() => {
      let editor = new VisualEditorPackage.VisualEditor()
      editor.defineElement();

      console.log('VisualEditorElement.jsx onMounted', field);
    }, [])

    const showEditor = () => {
        setHidden(!hidden);
    }

    const additionnals_props = {
        ...(hidden && { hidden: true })
    }
  
    return <>
        <div {...field.sibling_attr} id={field.sibling}>
            <div {...field.wrapper}>
            {field.label_show &&
                <Form.Label {...field.label_attr} htmlFor={field.name}>{field.label}</Form.Label>
            }
            <Button onClick={showEditor}>
                Toggle Visual Editor
            </Button>
            
            <visual-editor {...register(field.name)} {...additionnals_props} name={field.name} preview={field.visual_editor_options.preview} value={field.value ? field.value : []}></visual-editor>

            {field.help_block.text &&
                <Form.Text {...field.help_block.attr} as={field.help_block.tag} muted>
                {field.help_block.text}
                </Form.Text>
            }
            </div>
        </div>
    </>   
}