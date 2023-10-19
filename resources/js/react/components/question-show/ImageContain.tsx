import React from 'react';

interface Props {
    src: string;
}

export const ImageContain: React.FC<Props> = ({ src }) => {
    
    return <div className='w-28 h-20 py-3'>
        <img className='w-full h-full object-contain' src={ src } alt='Зображення' />
    </div>
}