import React, {useMemo, useEffect} from 'react';
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';

export default function VisualEditorElement(props) {
    const field = useMemo(() => props.field, []);

    useEffect(() => {
      console.log('VisualEditorElement.jsx onMounted', field);
    }, [])
  
    return <>
        <div {...field.wrapper}>
          {field.label_show &&
            <Form.Label {...field.label_attr} htmlFor={field.name}>{field.label}</Form.Label>
          }
          <Button>
            Toggle Visual Editor
          </Button>
          
          {/* <visual-editor hidden name={field.name} preview={field.visual_editor_options.preview} value={field.value ? field.value : []}></visual-editor> */}

          {field.help_block.text &&
            <Form.Text {...field.help_block.attr} as={field.help_block.tag} muted>
              {field.help_block.text}
            </Form.Text>
          }
        </div>
    </>   
}