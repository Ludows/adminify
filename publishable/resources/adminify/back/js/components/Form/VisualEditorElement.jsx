import React, {useMemo, useRef, useEffect, useState, forwardRef} from 'react';
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import * as VisualEditorPackage from '@boxraiser/visual-editor/VisualEditor.standalone';

const VisualEditorElement = forwardRef((props, ref) => {
    const field = useMemo(() => props.field, []);
    const errors = useMemo(() => props.errors ?? {}, []);
    const TagEditor = `${field.visual_editor_options.visual_element}`;
    const [hidden, setHidden] = useState(true);
    const [data, setData] = useState('[]');

    const register = useMemo(() => props.register, [props]);

    const EditorRef = useRef({});

    useEffect(() => {
      let editor = new VisualEditorPackage.VisualEditor()
      editor.defineElement( field.visual_editor_options.visual_element );

    //   console.log('VisualEditorElement.jsx onMounted', field);

      return () => {

      }
    }, [])

    const showEditor = () => {
        setHidden(!hidden);
    }

    const onChangeEditor = (value) => {
        console.log('data changed!', value)
        setData(value);
    }

    const additionnals_props = {
        ...(hidden && { hidden: true })
    }
  
    return <>
        <div ref={ref} {...field.sibling_attr} id={field.sibling}>
            <div {...field.wrapper}>
            {field.label_show &&
                <Form.Label {...field.label_attr} htmlFor={field.name}>{field.label}</Form.Label>
            }
            <Button onClick={showEditor}>
                Toggle Visual Editor
            </Button>
            
            <TagEditor onChange={onChangeEditor} ref={EditorRef} {...additionnals_props} preview={field.visual_editor_options.preview} value={field.value ? field.value : []}></TagEditor>
            <input type='hidden' {...register(field.name)} name={field.name} value={data} />

            {field.help_block.text &&
                <Form.Text {...field.help_block.attr} as={field.help_block.tag} muted>
                {field.help_block.text}
                </Form.Text>
            }
            </div>
        </div>
    </>   
})

export default VisualEditorElement;